<?php

namespace Ksfraser\SupportTickets\Service;

use Ksfraser\SupportTickets\Entity\SupportTicket;
use Ksfraser\SupportTickets\Entity\TicketActivity;
use Ksfraser\SupportTickets\Entity\TicketNote;
use Ksfraser\SupportTickets\Entity\TicketItem;
use Psr\EventDispatcher\EventDispatcherInterface;

class TicketService
{
    private ?EventDispatcherInterface $eventDispatcher;
    private array $ticketRepository;
    private array $activityRepository;
    private array $noteRepository;
    private array $itemRepository;

    public function __construct(?EventDispatcherInterface $dispatcher = null)
    {
        $this->eventDispatcher = $dispatcher;
    }

    public function createTicket(array $data): SupportTicket
    {
        $ticket = new SupportTicket($data);
        $this->ticketRepository[$ticket->getId() ?? $ticket->getTicketNumber()] = $ticket;
        $this->dispatchEvent(new \Ksfraser\SupportTickets\Events\TicketCreatedEvent($ticket));
        return $ticket;
    }

    public function updateTicket(int $ticketId, array $data): ?SupportTicket
    {
        if (!isset($this->ticketRepository[$ticketId])) return null;
        
        $ticket = $this->ticketRepository[$ticketId];
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (method_exists($ticket, $method)) {
                $ticket->$method($value);
            }
        }
        $this->ticketRepository[$ticketId] = $ticket;
        $this->dispatchEvent(new \Ksfraser\SupportTickets\Events\TicketUpdatedEvent($ticket));
        return $ticket;
    }

    public function closeTicket(int $ticketId): ?SupportTicket
    {
        return $this->updateTicket($ticketId, ['state' => 'Closed', 'status' => 'Resolved']);
    }

    public function assignTicket(int $ticketId, string $assignedTo, ?int $teamId = null): ?SupportTicket
    {
        $data = ['assigned_to' => $assignedTo];
        if ($teamId) $data['team_id'] = $teamId;
        return $this->updateTicket($ticketId, $data);
    }

    public function addActivity(int $ticketId, array $activityData): TicketActivity
    {
        $activityData['ticket_id'] = $ticketId;
        $activity = new TicketActivity($activityData);
        $this->activityRepository[$ticketId][] = $activity;
        return $activity;
    }

    public function addNote(int $ticketId, array $noteData): TicketNote
    {
        $noteData['ticket_id'] = $ticketId;
        $note = new TicketNote($noteData);
        $this->noteRepository[$ticketId][] = $note;
        return $note;
    }

    public function addItem(int $ticketId, array $itemData): TicketItem
    {
        $itemData['ticket_id'] = $ticketId;
        $item = new TicketItem($itemData);
        $this->itemRepository[$ticketId][] = $item;
        return $item;
    }

    public function getTicket(int $ticketNumber): ?SupportTicket
    {
        return $this->ticketRepository[$ticketNumber] ?? null;
    }

    public function getAllTickets(?string $status = null, ?string $priority = null): array
    {
        $tickets = array_values($this->ticketRepository);
        if ($status) {
            $tickets = array_filter($tickets, fn($t) => $t->getStatus() === $status);
        }
        if ($priority) {
            $tickets = array_filter($tickets, fn($t) => $t->getPriority() === $priority);
        }
        return array_values($tickets);
    }

    public function getTicketActivities(int $ticketId): array
    {
        return $this->activityRepository[$ticketId] ?? [];
    }

    public function getTicketNotes(int $ticketId): array
    {
        return $this->noteRepository[$ticketId] ?? [];
    }

    public function getTicketItems(int $ticketId): array
    {
        return $this->itemRepository[$ticketId] ?? [];
    }

    public function getTicketTotal(int $ticketId): float
    {
        return array_sum(array_map(
            fn($item) => $item->getLineTotal(),
            $this->getTicketItems($ticketId)
        ));
    }

    private function dispatchEvent($event): void
    {
        if ($this->eventDispatcher) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}
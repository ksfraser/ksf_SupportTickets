<?php

declare(strict_types=1);

namespace Ksfraser\SupportTickets\Events;

use Ksfraser\SupportTickets\Entity\SupportTicket;
use Psr\EventDispatcher\StoppableEventInterface;

class TicketUpdatedEvent implements StoppableEventInterface
{
    private SupportTicket $ticket;
    private ?array $oldData;

    public function __construct(SupportTicket $ticket, ?array $oldData = null)
    {
        $this->ticket = $ticket;
        $this->oldData = $oldData;
    }

    public function getTicket(): SupportTicket
    {
        return $this->ticket;
    }

    public function getOldData(): ?array
    {
        return $this->oldData;
    }

    public function isPropagationStopped(): bool
    {
        return false;
    }
}

class TicketClosedEvent implements StoppableEventInterface
{
    private SupportTicket $ticket;
    private string $resolution;

    public function __construct(SupportTicket $ticket, string $resolution = '')
    {
        $this->ticket = $ticket;
        $this->resolution = $resolution;
    }

    public function getTicket(): SupportTicket
    {
        return $this->ticket;
    }

    public function getResolution(): string
    {
        return $this->resolution;
    }

    public function isPropagationStopped(): bool
    {
        return false;
    }
}
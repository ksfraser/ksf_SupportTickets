<?php

declare(strict_types=1);

namespace Ksfraser\SupportTickets\Entity;

use Ksfraser\SupportTickets\Events\TicketCreatedEvent;
use Ksfraser\SupportTickets\Events\TicketUpdatedEvent;
use Ksfraser\SupportTickets\Events\TicketClosedEvent;

class SupportTicket
{
    private ?int $id = null;
    private string $ticketNumber;
    private string $subject;
    private ?string $description;
    private string $type;
    private string $state;
    private string $status;
    private string $priority;
    private ?string $debtorNo;
    private ?int $contactId;
    private ?int $warrantyId;
    private ?string $assignedTo;
    private ?int $teamId;
    private ?int $projectId;
    private ?int $invoiceId;
    private array $activities;
    private array $notes;
    private array $items;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->ticketNumber = $data['ticket_number'] ?? $this->generateTicketNumber();
        $this->subject = $data['subject'] ?? '';
        $this->description = $data['description'] ?? null;
        $this->type = $data['type'] ?? 'Question';
        $this->state = $data['state'] ?? 'Open';
        $this->status = $data['status'] ?? 'New';
        $this->priority = $data['priority'] ?? 'Medium';
        $this->debtorNo = $data['debtor_no'] ?? null;
        $this->contactId = $data['contact_id'] ?? null;
        $this->warrantyId = $data['warranty_id'] ?? null;
        $this->assignedTo = $data['assigned_to'] ?? null;
        $this->teamId = $data['team_id'] ?? null;
        $this->projectId = $data['project_id'] ?? null;
        $this->invoiceId = $data['invoice_id'] ?? null;
        $this->activities = $data['activities'] ?? [];
        $this->notes = $data['notes'] ?? [];
        $this->items = $data['items'] ?? [];
        $this->createdAt = new \DateTime($data['created_at'] ?? 'now');
        $this->updatedAt = new \DateTime($data['updated_at'] ?? 'now');
    }

    private function generateTicketNumber(): string
    {
        return 'TKT-' . date('Ymd') . '-' . substr(md5(uniqid()), 0, 6);
    }

    public function getId(): ?int { return $this->id; }
    public function getTicketNumber(): string { return $this->ticketNumber; }
    public function getSubject(): string { return $this->subject; }
    public function getDescription(): ?string { return $this->description; }
    public function getType(): string { return $this->type; }
    public function getState(): string { return $this->state; }
    public function getStatus(): string { return $this->status; }
    public function getPriority(): string { return $this->priority; }
    public function getDebtorNo(): ?string { return $this->debtorNo; }
    public function getContactId(): ?int { return $this->contactId; }
    public function getWarrantyId(): ?int { return $this->warrantyId; }
    public function getAssignedTo(): ?string { return $this->assignedTo; }
    public function getTeamId(): ?int { return $this->teamId; }
    public function getProjectId(): ?int { return $this->projectId; }
    public function getInvoiceId(): ?int { return $this->invoiceId; }
    public function getActivities(): array { return $this->activities; }
    public function getNotes(): array { return $this->notes; }
    public function getItems(): array { return $this->items; }
    public function getCreatedAt(): \DateTime { return $this->createdAt; }
    public function getUpdatedAt(): \DateTime { return $this->updatedAt; }

    public function setSubject(string $subject): self { $this->subject = $subject; return $this; }
    public function setDescription(?string $description): self { $this->description = $description; return $this; }
    public function setType(string $type): self { $this->type = $type; return $this; }
    public function setState(string $state): self { $this->state = $state; return $this; }
    public function setStatus(string $status): self { $this->status = $status; return $this; }
    public function setPriority(string $priority): self { $this->priority = $priority; return $this; }
    public function setDebtorNo(?string $debtorNo): self { $this->debtorNo = $debtorNo; return $this; }
    public function setContactId(?int $contactId): self { $this->contactId = $contactId; return $this; }
    public function setWarrantyId(?int $warrantyId): self { $this->warrantyId = $warrantyId; return $this; }
    public function setAssignedTo(?string $assignedTo): self { $this->assignedTo = $assignedTo; return $this; }
    public function setTeamId(?int $teamId): self { $this->teamId = $teamId; return $this; }
    public function setProjectId(?int $projectId): self { $this->projectId = $projectId; return $this; }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'ticket_number' => $this->ticketNumber,
            'subject' => $this->subject,
            'description' => $this->description,
            'type' => $this->type,
            'state' => $this->state,
            'status' => $this->status,
            'priority' => $this->priority,
            'debtor_no' => $this->debtorNo,
            'contact_id' => $this->contactId,
            'warranty_id' => $this->warrantyId,
            'assigned_to' => $this->assignedTo,
            'team_id' => $this->teamId,
            'project_id' => $this->projectId,
            'invoice_id' => $this->invoiceId,
            'activities' => $this->activities,
            'notes' => $this->notes,
            'items' => $this->items,
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
            'updated_at' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }

    public function isOpen(): bool { return $this->state === 'Open'; }
    public function isClosed(): bool { return $this->state === 'Closed'; }
    public function isHighPriority(): bool { return in_array($this->priority, ['High', 'Critical']); }
}
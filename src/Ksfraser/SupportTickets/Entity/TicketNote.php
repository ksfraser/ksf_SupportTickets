<?php

namespace Ksfraser\SupportTickets\Entity;

class TicketNote
{
    private ?int $id;
    private int $ticketId;
    private string $note;
    private string $noteType;
    private string $createdBy;
    private \DateTime $createdAt;

    public const TYPE_GENERAL = 'General';
    public const TYPE_INTERNAL = 'Internal';
    public const TYPE_RESOLUTION = 'Resolution';

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->ticketId = $data['ticket_id'] ?? 0;
        $this->note = $data['note'] ?? $data['content'] ?? '';
        $this->noteType = $data['note_type'] ?? self::TYPE_GENERAL;
        $this->createdBy = $data['created_by'] ?? '';
        $this->createdAt = new \DateTime($data['created_at'] ?? 'now');
    }

    public function getId(): ?int { return $this->id; }
    public function setTicketId(int $ticketId): self { $this->ticketId = $ticketId; return $this; }
    public function getTicketId(): int { return $this->ticketId; }
    public function getNote(): string { return $this->note; }
    public function setNote(string $note): self { $this->note = $note; return $this; }
    public function getContent(): string { return $this->note; }
    public function setContent(string $content): self { $this->note = $content; return $this; }
    public function getNoteType(): string { return $this->noteType; }
    public function getCreatedBy(): string { return $this->createdBy; }
    public function getCreatedAt(): \DateTime { return $this->createdAt; }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'ticket_id' => $this->ticketId,
            'note' => $this->note,
            'note_type' => $this->noteType,
            'created_by' => $this->createdBy,
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
        ];
    }
}
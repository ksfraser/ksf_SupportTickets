<?php

namespace Ksfraser\SupportTickets\Entity;

class TicketActivity
{
    private ?int $id;
    private int $ticketId;
    private string $activityType;
    private string $direction;
    private ?string $subject;
    private ?string $message;
    private ?string $emailFrom;
    private ?string $emailTo;
    private ?string $phoneNumber;
    private ?int $duration;
    private ?string $assignedTo;
    private \DateTime $scheduledAt;
    private \DateTime $completedAt;
    private string $status;
    private \DateTime $createdAt;

    public const TYPE_EMAIL = 'Email';
    public const TYPE_CALL = 'Call';
    public const TYPE_TEXT = 'Text';
    public const TYPE_TASK = 'Task';
    public const TYPE_MEETING = 'Meeting';
    public const TYPE_NOTE = 'Note';

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->ticketId = $data['ticket_id'] ?? 0;
        $this->activityType = $data['activity_type'] ?? self::TYPE_NOTE;
        $this->direction = $data['direction'] ?? 'outbound';
        $this->subject = $data['subject'] ?? null;
        $this->message = $data['message'] ?? null;
        $this->emailFrom = $data['email_from'] ?? null;
        $this->emailTo = $data['email_to'] ?? null;
        $this->phoneNumber = $data['phone_number'] ?? null;
        $this->duration = $data['duration'] ?? null;
        $this->assignedTo = $data['assigned_to'] ?? null;
        $this->scheduledAt = new \DateTime($data['scheduled_at'] ?? 'now');
        $this->completedAt = new \DateTime($data['completed_at'] ?? 'now');
        $this->status = $data['status'] ?? 'Completed';
        $this->createdAt = new \DateTime($data['created_at'] ?? 'now');
    }

    public function getId(): ?int { return $this->id; }
    public function getTicketId(): int { return $this->ticketId; }
    public function getActivityType(): string { return $this->activityType; }
    public function getDirection(): string { return $this->direction; }
    public function getSubject(): ?string { return $this->subject; }
    public function getMessage(): ?string { return $this->message; }
    public function getEmailFrom(): ?string { return $this->emailFrom; }
    public function getEmailTo(): ?string { return $this->emailTo; }
    public function getPhoneNumber(): ?string { return $this->phoneNumber; }
    public function getDuration(): ?int { return $this->duration; }
    public function getStatus(): string { return $this->status; }
    public function getCreatedAt(): \DateTime { return $this->createdAt; }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'ticket_id' => $this->ticketId,
            'activity_type' => $this->activityType,
            'direction' => $this->direction,
            'subject' => $this->subject,
            'message' => $this->message,
            'email_from' => $this->emailFrom,
            'email_to' => $this->emailTo,
            'phone_number' => $this->phoneNumber,
            'duration' => $this->duration,
            'assigned_to' => $this->assignedTo,
            'scheduled_at' => $this->scheduledAt->format('Y-m-d H:i:s'),
            'completed_at' => $this->completedAt->format('Y-m-d H:i:s'),
            'status' => $this->status,
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
        ];
    }
}
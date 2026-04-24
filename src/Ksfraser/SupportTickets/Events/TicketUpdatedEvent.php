<?php

namespace Ksfraser\SupportTickets\Events;

class TicketUpdatedEvent
{
    private $ticket;
    private ?array $oldData;

    public function __construct($ticket, ?array $oldData = null)
    {
        $this->ticket = $ticket;
        $this->oldData = $oldData;
    }

    public function getTicket() { return $this->ticket; }
    public function getOldData(): ?array { return $this->oldData; }
}

class TicketClosedEvent
{
    private $ticket;
    private string $resolution;

    public function __construct($ticket, string $resolution = '')
    {
        $this->ticket = $ticket;
        $this->resolution = $resolution;
    }

    public function getTicket() { return $this->ticket; }
    public function getResolution(): string { return $this->resolution; }
}
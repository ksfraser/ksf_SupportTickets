<?php

namespace Ksfraser\SupportTickets\Events;

use Ksfraser\SupportTickets\Entity\SupportTicket;
use Psr\EventDispatcher\StoppableEventInterface;

class TicketCreatedEvent implements StoppableEventInterface
{
    private SupportTicket $ticket;

    public function __construct(SupportTicket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function getTicket(): SupportTicket
    {
        return $this->ticket;
    }

    public function isPropagationStopped(): bool
    {
        return false;
    }
}
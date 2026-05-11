<?php

declare(strict_types=1);

namespace Ksfraser\Tests\Unit\SupportTickets\Events;

use Ksfraser\SupportTickets\Entity\SupportTicket;
use Ksfraser\SupportTickets\Events\TicketCreatedEvent;
use PHPUnit\Framework\TestCase;

class TicketCreatedEventTest extends TestCase
{
    /**
     * @covers Ksfraser\SupportTickets\Events\TicketCreatedEvent::__construct
     * @covers Ksfraser\SupportTickets\Events\TicketCreatedEvent::getTicket
     */
    public function testGetTicket(): void
    {
        $ticket = new SupportTicket(['id' => 1, 'subject' => 'Test']);
        $event = new TicketCreatedEvent($ticket);

        $this->assertInstanceOf(SupportTicket::class, $event->getTicket());
        $this->assertSame($ticket, $event->getTicket());
        $this->assertSame(1, $event->getTicket()->getId());
        $this->assertSame('Test', $event->getTicket()->getSubject());
    }

    /**
     * @covers Ksfraser\SupportTickets\Events\TicketCreatedEvent::isPropagationStopped
     */
    public function testIsPropagationStopped(): void
    {
        $ticket = new SupportTicket();
        $event = new TicketCreatedEvent($ticket);

        $this->assertFalse($event->isPropagationStopped());
    }
}
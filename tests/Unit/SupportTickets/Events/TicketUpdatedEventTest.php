<?php

declare(strict_types=1);

namespace Ksfraser\Tests\Unit\SupportTickets\Events;

use Ksfraser\SupportTickets\Entity\SupportTicket;
use Ksfraser\SupportTickets\Events\TicketUpdatedEvent;
use PHPUnit\Framework\TestCase;

class TicketUpdatedEventTest extends TestCase
{
    /**
     * @covers Ksfraser\SupportTickets\Events\TicketUpdatedEvent::__construct
     * @covers Ksfraser\SupportTickets\Events\TicketUpdatedEvent::getTicket
     */
    public function testGetTicket(): void
    {
        $ticket = new SupportTicket(['id' => 2, 'subject' => 'Updated Test']);
        $event = new TicketUpdatedEvent($ticket);

        $this->assertInstanceOf(SupportTicket::class, $event->getTicket());
        $this->assertSame($ticket, $event->getTicket());
    }

    /**
     * @covers Ksfraser\SupportTickets\Events\TicketUpdatedEvent::isPropagationStopped
     */
    public function testIsPropagationStopped(): void
    {
        $ticket = new SupportTicket();
        $event = new TicketUpdatedEvent($ticket);

        $this->assertFalse($event->isPropagationStopped());
    }
}
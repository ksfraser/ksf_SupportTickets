<?php

declare(strict_types=1);

namespace Ksfraser\Tests\Unit\SupportTickets\Entity;

use Ksfraser\SupportTickets\Entity\SupportTicket;
use PHPUnit\Framework\TestCase;

class SupportTicketTest extends TestCase
{
    public function testDefaultValues(): void
    {
        $ticket = new SupportTicket();

        $this->assertNull($ticket->getId());
        $this->assertNotEmpty($ticket->getTicketNumber());
        $this->assertStringStartsWith('TKT-', $ticket->getTicketNumber());
        $this->assertSame('', $ticket->getSubject());
        $this->assertNull($ticket->getDescription());
        $this->assertSame('Question', $ticket->getType());
        $this->assertSame('Open', $ticket->getState());
        $this->assertSame('New', $ticket->getStatus());
        $this->assertSame('Medium', $ticket->getPriority());
    }

    /**
     * @covers Ksfraser\SupportTickets\Entity\SupportTicket::__construct
     * @covers Ksfraser\SupportTickets\Entity\SupportTicket::getId
     * @covers Ksfraser\SupportTickets\Entity\SupportTicket::getTicketNumber
     */
    public function testConstructWithData(): void
    {
        $ticket = new SupportTicket([
            'id' => 123,
            'ticket_number' => 'TKT-20260101-ABC123',
            'subject' => 'Test Subject',
        ]);

        $this->assertSame(123, $ticket->getId());
        $this->assertSame('TKT-20260101-ABC123', $ticket->getTicketNumber());
        $this->assertSame('Test Subject', $ticket->getSubject());
    }

    /**
     * @covers Ksfraser\SupportTickets\Entity\SupportTicket::setSubject
     * @covers Ksfraser\SupportTickets\Entity\SupportTicket::getSubject
     */
    public function testSetSubject(): void
    {
        $ticket = new SupportTicket();
        $result = $ticket->setSubject('New Subject');

        $this->assertInstanceOf(SupportTicket::class, $result);
        $this->assertSame('New Subject', $ticket->getSubject());
    }

    /**
     * @covers Ksfraser\SupportTickets\Entity\SupportTicket::setStatus
     * @covers Ksfraser\SupportTickets\Entity\SupportTicket::getStatus
     */
    public function testSetStatus(): void
    {
        $ticket = new SupportTicket();
        $result = $ticket->setStatus('In Progress');

        $this->assertInstanceOf(SupportTicket::class, $result);
        $this->assertSame('In Progress', $ticket->getStatus());
    }

    /**
     * @covers Ksfraser\SupportTickets\Entity\SupportTicket::setPriority
     * @covers Ksfraser\SupportTickets\Entity\SupportTicket::getPriority
     */
    public function testSetPriority(): void
    {
        $ticket = new SupportTicket();
        $result = $ticket->setPriority('High');

        $this->assertInstanceOf(SupportTicket::class, $result);
        $this->assertSame('High', $ticket->getPriority());
    }

    /**
     * @covers Ksfraser\SupportTickets\Entity\SupportTicket::isOpen
     */
    public function testIsOpen(): void
    {
        $ticket = new SupportTicket();
        $this->assertTrue($ticket->isOpen());

        $ticket->setState('Closed');
        $this->assertFalse($ticket->isOpen());
    }

    /**
     * @covers Ksfraser\SupportTickets\Entity\SupportTicket::isClosed
     */
    public function testIsClosed(): void
    {
        $ticket = new SupportTicket();
        $this->assertFalse($ticket->isClosed());

        $ticket->setState('Closed');
        $this->assertTrue($ticket->isClosed());
    }

    /**
     * @covers Ksfraser\SupportTickets\Entity\SupportTicket::isHighPriority
     */
    public function testIsHighPriority(): void
    {
        $ticket = new SupportTicket();
        $ticket->setPriority('Low');
        $this->assertFalse($ticket->isHighPriority());

        $ticket->setPriority('High');
        $this->assertTrue($ticket->isHighPriority());
    }

    /**
     * @covers Ksfraser\SupportTickets\Entity\SupportTicket::toArray
     */
    public function testToArray(): void
    {
        $ticket = new SupportTicket([
            'id' => 1,
            'subject' => 'Test',
        ]);

        $array = $ticket->toArray();

        $this->assertIsArray($array);
        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('ticket_number', $array);
        $this->assertArrayHasKey('subject', $array);
        $this->assertArrayHasKey('status', $array);
        $this->assertArrayHasKey('priority', $array);
    }

    /**
     * @covers Ksfraser\SupportTickets\Entity\SupportTicket::setContactId
     * @covers Ksfraser\SupportTickets\Entity\SupportTicket::getContactId
     */
    public function testSetContactId(): void
    {
        $ticket = new SupportTicket();
        $result = $ticket->setContactId(456);

        $this->assertInstanceOf(SupportTicket::class, $result);
        $this->assertSame(456, $ticket->getContactId());
    }

    /**
     * @covers Ksfraser\SupportTickets\Entity\SupportTicket::setTeamId
     * @covers Ksfraser\SupportTickets\Entity\SupportTicket::getTeamId
     */
    public function testSetTeamId(): void
    {
        $ticket = new SupportTicket();
        $result = $ticket->setTeamId(789);

        $this->assertInstanceOf(SupportTicket::class, $result);
        $this->assertSame(789, $ticket->getTeamId());
    }
}
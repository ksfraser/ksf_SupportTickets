<?php

namespace Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use Ksfraser\SupportTickets\Entity\SupportTicket;

class SupportTicketTest extends TestCase
{
    public function testCreateWithDefaults(): void
    {
        $ticket = new SupportTicket(['subject' => 'Test']);
        
        $this->assertEquals('Test', $ticket->getSubject());
        $this->assertEquals('Question', $ticket->getType());
        $this->assertEquals('Open', $ticket->getState());
        $this->assertEquals('New', $ticket->getStatus());
        $this->assertEquals('Medium', $ticket->getPriority());
        $this->assertTrue($ticket->isOpen());
    }

    public function testCreateFullData(): void
    {
        $data = [
            'subject' => 'Help needed',
            'description' => 'Cannot login',
            'type' => 'Issue',
            'priority' => 'High',
            'debtor_no' => 'D001',
            'contact_id' => 1,
        ];
        
        $ticket = new SupportTicket($data);
        
        $this->assertEquals('Help needed', $ticket->getSubject());
        $this->assertEquals('Cannot login', $ticket->getDescription());
        $this->assertEquals('Issue', $ticket->getType());
        $this->assertEquals('High', $ticket->getPriority());
        $this->assertEquals('D001', $ticket->getDebtorNo());
        $this->assertEquals(1, $ticket->getContactId());
    }

    public function testTicketNumberFormat(): void
    {
        $ticket = new SupportTicket(['subject' => 'Test']);
        
        $this->assertStringStartsWith('TKT-', $ticket->getTicketNumber());
    }

    public function testIsOpen(): void
    {
        $ticket = new SupportTicket(['subject' => 'Test', 'state' => 'Open']);
        $this->assertTrue($ticket->isOpen());
        $this->assertFalse($ticket->isClosed());
    }

    public function testIsClosed(): void
    {
        $ticket = new SupportTicket(['subject' => 'Test', 'state' => 'Closed']);
        $this->assertFalse($ticket->isOpen());
        $this->assertTrue($ticket->isClosed());
    }

    public function testHighPriority(): void
    {
        $ticketHigh = new SupportTicket(['subject' => 'Test', 'priority' => 'Critical']);
        $ticketLow = new SupportTicket(['subject' => 'Test', 'priority' => 'Low']);
        
        $this->assertTrue($ticketHigh->isHighPriority());
        $this->assertFalse($ticketLow->isHighPriority());
    }

    public function testSettersReturnSelf(): void
    {
        $ticket = new SupportTicket(['subject' => 'Test']);
        
        $result = $ticket->setStatus('InProgress');
        $this->assertSame($ticket, $result);
    }

    public function testToArrayContainsAllFields(): void
    {
        $ticket = new SupportTicket([
            'subject' => 'Test',
            'type' => 'Issue',
            'priority' => 'High',
        ]);
        
        $arr = $ticket->toArray();
        
        $this->assertIsArray($arr);
        $this->assertArrayHasKey('subject', $arr);
        $this->assertArrayHasKey('type', $arr);
        $this->assertArrayHasKey('priority', $arr);
        $this->assertArrayHasKey('ticket_number', $arr);
        $this->assertArrayHasKey('state', $arr);
    }

    public function testAssignWarranty(): void
    {
        $ticket = new SupportTicket(['subject' => 'Test']);
        $ticket->setWarrantyId(123);
        
        $this->assertEquals(123, $ticket->getWarrantyId());
    }

    public function testToArray(): void
    {
        $ticket = new SupportTicket([
            'subject' => 'Test',
            'type' => 'Issue',
            'priority' => 'High',
        ]);
        
        $arr = $ticket->toArray();
        
        $this->assertEquals('Test', $arr['subject']);
        $this->assertEquals('Issue', $arr['type']);
        $this->assertEquals('High', $arr['priority']);
    }
}
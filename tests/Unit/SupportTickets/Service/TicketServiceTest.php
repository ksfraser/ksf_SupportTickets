<?php

declare(strict_types=1);

namespace Ksfraser\Tests\Unit\SupportTickets\Service;

use Ksfraser\SupportTickets\Entity\SupportTicket;
use Ksfraser\SupportTickets\Service\TicketService;
use PHPUnit\Framework\TestCase;

class TicketServiceTest extends TestCase
{
    private TicketService $service;

    protected function setUp(): void
    {
        $this->service = new TicketService();
    }

    /**
     * @covers Ksfraser\SupportTickets\Service\TicketService::createTicket
     */
    public function testCreateTicket(): void
    {
        $data = [
            'id' => 1,
            'subject' => 'Test Ticket',
            'priority' => 'High',
        ];

        $ticket = $this->service->createTicket($data);

        $this->assertInstanceOf(SupportTicket::class, $ticket);
        $this->assertSame('Test Ticket', $ticket->getSubject());
        $this->assertSame('High', $ticket->getPriority());
        $this->assertNotEmpty($ticket->getTicketNumber());
    }

    /**
     * @covers Ksfraser\SupportTickets\Service\TicketService::getTicket
     */
    public function testGetTicket(): void
    {
        $created = $this->service->createTicket(['id' => 2, 'subject' => 'Find Me']);

        $found = $this->service->getTicket(2);

        $this->assertNotNull($found);
        $this->assertSame('Find Me', $found->getSubject());
    }

    /**
     * @covers Ksfraser\SupportTickets\Service\TicketService::updateTicket
     */
    public function testUpdateTicket(): void
    {
        $this->service->createTicket(['id' => 3, 'subject' => 'Original']);

        $updated = $this->service->updateTicket(3, ['subject' => 'Updated']);

        $this->assertNotNull($updated);
        $this->assertSame('Updated', $updated->getSubject());
    }

    /**
     * @covers Ksfraser\SupportTickets\Service\TicketService::closeTicket
     */
    public function testCloseTicket(): void
    {
        $this->service->createTicket(['id' => 4, 'state' => 'Open']);

        $closed = $this->service->closeTicket(4);

        $this->assertNotNull($closed);
        $this->assertSame('Closed', $closed->getState());
        $this->assertSame('Resolved', $closed->getStatus());
    }

    /**
     * @covers Ksfraser\SupportTickets\Service\TicketService::assignTicket
     */
    public function testAssignTicket(): void
    {
        $this->service->createTicket(['id' => 5]);

        $assigned = $this->service->assignTicket(5, 'john.doe', 10);

        $this->assertNotNull($assigned);
        $this->assertSame('john.doe', $assigned->getAssignedTo());
        $this->assertSame(10, $assigned->getTeamId());
    }

    /**
     * @covers Ksfraser\SupportTickets\Service\TicketService::getAllTickets
     */
    public function testGetAllTickets(): void
    {
        $this->service->createTicket(['id' => 10, 'subject' => 'A']);
        $this->service->createTicket(['id' => 11, 'subject' => 'B']);

        $all = $this->service->getAllTickets();

        $this->assertCount(2, $all);
    }

    /**
     * @covers Ksfraser\SupportTickets\Service\TicketService::getAllTickets
     */
    public function testGetAllTicketsFilteredByPriority(): void
    {
        $this->service->createTicket(['id' => 20, 'subject' => 'Low', 'priority' => 'Low']);
        $this->service->createTicket(['id' => 21, 'subject' => 'High', 'priority' => 'High']);

        $high = $this->service->getAllTickets(null, 'High');

        $this->assertCount(1, $high);
        $this->assertSame('High', $high[0]->getPriority());
    }

    /**
     * @covers Ksfraser\SupportTickets\Service\TicketService::addActivity
     */
    public function testAddActivity(): void
    {
        $this->service->createTicket(['id' => 30]);

        $activity = $this->service->addActivity(30, ['message' => 'Worked on issue']);

        $this->assertNotEmpty($activity->getTicketId());
        $this->assertSame('Worked on issue', $activity->getMessage());
    }

    /**
     * @covers Ksfraser\SupportTickets\Service\TicketService::addNote
     */
    public function testAddNote(): void
    {
        $this->service->createTicket(['id' => 31]);

        $note = $this->service->addNote(31, ['content' => 'Important note']);

        $this->assertNotEmpty($note->getTicketId());
        $this->assertSame('Important note', $note->getContent());
    }

    /**
     * @covers Ksfraser\SupportTickets\Service\TicketService::getTicketNotes
     */
    public function testGetTicketNotes(): void
    {
        $this->service->createTicket(['id' => 32]);
        $this->service->addNote(32, ['content' => 'Note 1']);
        $this->service->addNote(32, ['content' => 'Note 2']);

        $notes = $this->service->getTicketNotes(32);

        $this->assertCount(2, $notes);
    }
}
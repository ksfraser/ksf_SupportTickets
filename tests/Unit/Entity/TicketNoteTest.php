<?php

namespace Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use Ksfraser\SupportTickets\Entity\TicketNote;

class TicketNoteTest extends TestCase
{
    public function testCreateNote(): void
    {
        $note = new TicketNote(['ticket_id' => 1, 'note' => 'Test note']);
        
        $this->assertEquals(1, $note->getTicketId());
        $this->assertEquals('Test note', $note->getNote());
        $this->assertEquals('General', $note->getNoteType());
    }

    public function testCreateInternalNote(): void
    {
        $note = new TicketNote([
            'ticket_id' => 1,
            'note' => 'Internal note',
            'note_type' => 'Internal',
        ]);
        
        $this->assertEquals('Internal', $note->getNoteType());
    }

    public function testCreateResolutionNote(): void
    {
        $note = new TicketNote([
            'ticket_id' => 1,
            'note' => 'Fixed the issue',
            'note_type' => 'Resolution',
        ]);
        
        $this->assertEquals('Resolution', $note->getNoteType());
    }

    public function testToArray(): void
    {
        $note = new TicketNote([
            'ticket_id' => 1,
            'note' => 'Test',
            'created_by' => 'user1',
        ]);
        
        $arr = $note->toArray();
        
        $this->assertIsArray($arr);
        $this->assertEquals('Test', $arr['note']);
        $this->assertEquals('user1', $arr['created_by']);
    }
}
<?php

declare(strict_types=1);

namespace Ksfraser\Tests\Unit\SupportTickets\Entity;

use Ksfraser\SupportTickets\Entity\TicketNote;
use PHPUnit\Framework\TestCase;

class TicketNoteTest extends TestCase
{
    public function testDefaultValues(): void
    {
        $note = new TicketNote();

        $this->assertNull($note->getId());
        $this->assertSame(0, $note->getTicketId());
        $this->assertSame('', $note->getNote());
        $this->assertSame('General', $note->getNoteType());
    }

    /**
     * @covers Ksfraser\SupportTickets\Entity\TicketNote::__construct
     */
    public function testConstructWithContent(): void
    {
        $note = new TicketNote(['content' => 'Test content']);

        $this->assertSame('Test content', $note->getNote());
        $this->assertSame('Test content', $note->getContent());
    }

    /**
     * @covers Ksfraser\SupportTickets\Entity\TicketNote::setContent
     */
    public function testSetContent(): void
    {
        $note = new TicketNote();
        $result = $note->setContent('New content');

        $this->assertInstanceOf(TicketNote::class, $result);
        $this->assertSame('New content', $note->getContent());
    }

    /**
     * @covers Ksfraser\SupportTickets\Entity\TicketNote::TYPE_INTERNAL
     * @covers Ksfraser\SupportTickets\Entity\TicketNote::TYPE_RESOLUTION
     */
    public function testTypeConstants(): void
    {
        $this->assertSame('General', TicketNote::TYPE_GENERAL);
        $this->assertSame('Internal', TicketNote::TYPE_INTERNAL);
        $this->assertSame('Resolution', TicketNote::TYPE_RESOLUTION);
    }

    /**
     * @covers Ksfraser\SupportTickets\Entity\TicketNote::toArray
     */
    public function testToArray(): void
    {
        $note = new TicketNote(['note' => 'Test note']);

        $array = $note->toArray();

        $this->assertIsArray($array);
        $this->assertArrayHasKey('note', $array);
        $this->assertArrayHasKey('ticket_id', $array);
    }
}
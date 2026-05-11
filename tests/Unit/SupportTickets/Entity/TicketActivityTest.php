<?php

declare(strict_types=1);

namespace Ksfraser\Tests\Unit\SupportTickets\Entity;

use Ksfraser\SupportTickets\Entity\TicketActivity;
use PHPUnit\Framework\TestCase;

class TicketActivityTest extends TestCase
{
    public function testDefaultValues(): void
    {
        $activity = new TicketActivity();

        $this->assertNull($activity->getId());
        $this->assertSame(0, $activity->getTicketId());
        $this->assertSame('Note', $activity->getActivityType());
        $this->assertSame('outbound', $activity->getDirection());
        $this->assertNull($activity->getSubject());
        $this->assertNull($activity->getMessage());
    }

    /**
     * @covers Ksfraser\SupportTickets\Entity\TicketActivity::__construct
     */
    public function testConstructWithData(): void
    {
        $activity = new TicketActivity([
            'id' => 1,
            'ticket_id' => 100,
            'activity_type' => TicketActivity::TYPE_EMAIL,
            'direction' => 'inbound',
            'subject' => 'Test Subject',
            'message' => 'Test message',
        ]);

        $this->assertSame(1, $activity->getId());
        $this->assertSame(100, $activity->getTicketId());
        $this->assertSame('Email', $activity->getActivityType());
        $this->assertSame('inbound', $activity->getDirection());
        $this->assertSame('Test Subject', $activity->getSubject());
        $this->assertSame('Test message', $activity->getMessage());
    }

    /**
     * @covers Ksfraser\SupportTickets\Entity\TicketActivity::TYPE_EMAIL
     * @covers Ksfraser\SupportTickets\Entity\TicketActivity::TYPE_CALL
     */
    public function testTypeConstants(): void
    {
        $this->assertSame('Email', TicketActivity::TYPE_EMAIL);
        $this->assertSame('Call', TicketActivity::TYPE_CALL);
        $this->assertSame('Task', TicketActivity::TYPE_TASK);
        $this->assertSame('Meeting', TicketActivity::TYPE_MEETING);
    }

    /**
     * @covers Ksfraser\SupportTickets\Entity\TicketActivity::toArray
     */
    public function testToArray(): void
    {
        $activity = new TicketActivity(['id' => 5]);

        $array = $activity->toArray();

        $this->assertIsArray($array);
        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('ticket_id', $array);
        $this->assertArrayHasKey('activity_type', $array);
    }
}
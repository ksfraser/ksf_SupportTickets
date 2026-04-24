<?php

namespace Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use Ksfraser\SupportTickets\Entity\TicketActivity;

class TicketActivityTest extends TestCase
{
    public function testCreateWithDefaults(): void
    {
        $activity = new TicketActivity(['ticket_id' => 1]);
        
        $this->assertEquals(1, $activity->getTicketId());
        $this->assertEquals('Note', $activity->getActivityType());
        $this->assertEquals('outbound', $activity->getDirection());
    }

    public function testCreateEmailType(): void
    {
        $activity = new TicketActivity([
            'ticket_id' => 1,
            'activity_type' => 'Email',
            'email_from' => 'from@test.com',
            'email_to' => 'to@test.com',
        ]);
        
        $this->assertEquals('Email', $activity->getActivityType());
        $this->assertEquals('from@test.com', $activity->getEmailFrom());
        $this->assertEquals('to@test.com', $activity->getEmailTo());
    }

    public function testCreateCallType(): void
    {
        $activity = new TicketActivity([
            'ticket_id' => 1,
            'activity_type' => 'Call',
            'phone_number' => '555-1234',
            'duration' => 30,
        ]);
        
        $this->assertEquals('Call', $activity->getActivityType());
        $this->assertEquals('555-1234', $activity->getPhoneNumber());
    }

    public function testConstantsExist(): void
    {
        $this->assertEquals('Email', TicketActivity::TYPE_EMAIL);
        $this->assertEquals('Call', TicketActivity::TYPE_CALL);
        $this->assertEquals('Text', TicketActivity::TYPE_TEXT);
        $this->assertEquals('Task', TicketActivity::TYPE_TASK);
    }

    public function testToArray(): void
    {
        $activity = new TicketActivity([
            'ticket_id' => 1,
            'activity_type' => 'Call',
            'phone_number' => '555-1234',
        ]);
        
        $arr = $activity->toArray();
        
        $this->assertIsArray($arr);
        $this->assertEquals(1, $arr['ticket_id']);
        $this->assertEquals('Call', $arr['activity_type']);
    }
}
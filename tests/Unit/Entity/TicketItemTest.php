<?php

namespace Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use Ksfraser\SupportTickets\Entity\TicketItem;

class TicketItemTest extends TestCase
{
    public function testCreateItem(): void
    {
        $item = new TicketItem([
            'ticket_id' => 1,
            'item_description' => 'Service call',
            'quantity' => 1,
            'unit_price' => 100,
        ]);
        
        $this->assertEquals(1, $item->getTicketId());
        $this->assertEquals('Service call', $item->getItemDescription());
        $this->assertEquals(100, $item->getUnitPrice());
    }

    public function testLineTotalCalculation(): void
    {
        $item = new TicketItem([
            'ticket_id' => 1,
            'item_description' => 'Parts',
            'quantity' => 2,
            'unit_price' => 50,
        ]);
        
        $this->assertEquals(100, $item->getLineTotal());
    }

    public function testProductType(): void
    {
        $item = new TicketItem([
            'ticket_id' => 1,
            'item_type' => 'Product',
            'item_description' => 'Widget',
        ]);
        
        $this->assertEquals('Product', $item->getItemType());
    }

    public function testToArray(): void
    {
        $item = new TicketItem([
            'ticket_id' => 1,
            'item_description' => 'Test',
            'quantity' => 2,
            'unit_price' => 50,
        ]);
        
        $arr = $item->toArray();
        
        $this->assertIsArray($arr);
        $this->assertEquals(100, $arr['line_total'] ?? 0);
    }
}
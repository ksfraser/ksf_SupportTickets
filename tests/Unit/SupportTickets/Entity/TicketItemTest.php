<?php

declare(strict_types=1);

namespace Ksfraser\Tests\Unit\SupportTickets\Entity;

use Ksfraser\SupportTickets\Entity\TicketItem;
use PHPUnit\Framework\TestCase;

class TicketItemTest extends TestCase
{
    public function testDefaultValues(): void
    {
        $item = new TicketItem();

        $this->assertNull($item->getId());
        $this->assertSame(0, $item->getTicketId());
        $this->assertSame('Service', $item->getItemType());
        $this->assertSame('', $item->getItemDescription());
        $this->assertSame(1.0, $item->getQuantity());
        $this->assertSame(0.0, $item->getUnitPrice());
    }

    /**
     * @covers Ksfraser\SupportTickets\Entity\TicketItem::__construct
     */
    public function testConstructWithData(): void
    {
        $item = new TicketItem([
            'id' => 1,
            'ticket_id' => 100,
            'item_type' => TicketItem::TYPE_PRODUCT,
            'item_description' => 'Widget',
            'quantity' => 5,
            'unit_price' => 29.99,
        ]);

        $this->assertSame(1, $item->getId());
        $this->assertSame(100, $item->getTicketId());
        $this->assertSame('Product', $item->getItemType());
        $this->assertSame('Widget', $item->getItemDescription());
        $this->assertSame(5.0, $item->getQuantity());
        $this->assertSame(29.99, $item->getUnitPrice());
    }

    /**
     * @covers Ksfraser\SupportTickets\Entity\TicketItem::getLineTotal
     */
    public function testGetLineTotal(): void
    {
        $item = new TicketItem(['quantity' => 3, 'unit_price' => 10.0]);

        $this->assertSame(30.0, $item->getLineTotal());
    }

    /**
     * @covers Ksfraser\SupportTickets\Entity\TicketItem::TYPE_LABOR
     * @covers Ksfraser\SupportTickets\Entity\TicketItem::TYPE_TRAVEL
     */
    public function testTypeConstants(): void
    {
        $this->assertSame('Product', TicketItem::TYPE_PRODUCT);
        $this->assertSame('Service', TicketItem::TYPE_SERVICE);
        $this->assertSame('Parts', TicketItem::TYPE_PARTS);
        $this->assertSame('Labor', TicketItem::TYPE_LABOR);
        $this->assertSame('Travel', TicketItem::TYPE_TRAVEL);
    }

    /**
     * @covers Ksfraser\SupportTickets\Entity\TicketItem::toArray
     */
    public function testToArray(): void
    {
        $item = new TicketItem(['quantity' => 2, 'unit_price' => 15.0]);

        $array = $item->toArray();

        $this->assertIsArray($array);
        $this->assertArrayHasKey('quantity', $array);
        $this->assertArrayHasKey('unit_price', $array);
        $this->assertArrayHasKey('line_total', $array);
        $this->assertSame(30.0, $array['line_total']);
    }
}
<?php

namespace Ksfraser\SupportTickets\Entity;

class TicketItem
{
    private ?int $id;
    private int $ticketId;
    private string $itemType;
    private string $itemDescription;
    private float $quantity;
    private float $unitPrice;
    private ?string $unit;
    private ?int $invoiceId;
    private \DateTime $createdAt;

    public const TYPE_PRODUCT = 'Product';
    public const TYPE_SERVICE = 'Service';
    public const TYPE_PARTS = 'Parts';
    public const TYPE_LABOR = 'Labor';
    public const TYPE_TRAVEL = 'Travel';

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->ticketId = $data['ticket_id'] ?? 0;
        $this->itemType = $data['item_type'] ?? self::TYPE_SERVICE;
        $this->itemDescription = $data['item_description'] ?? '';
        $this->quantity = $data['quantity'] ?? 1;
        $this->unitPrice = $data['unit_price'] ?? 0;
        $this->unit = $data['unit'] ?? null;
        $this->invoiceId = $data['invoice_id'] ?? null;
        $this->createdAt = new \DateTime($data['created_at'] ?? 'now');
    }

    public function getId(): ?int { return $this->id; }
    public function getTicketId(): int { return $this->ticketId; }
    public function getItemType(): string { return $this->itemType; }
    public function getItemDescription(): string { return $this->itemDescription; }
    public function getQuantity(): float { return $this->quantity; }
    public function getUnitPrice(): float { return $this->unitPrice; }
    public function getLineTotal(): float { return $this->quantity * $this->unitPrice; }
    public function getInvoiceId(): ?int { return $this->invoiceId; }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'ticket_id' => $this->ticketId,
            'item_type' => $this->itemType,
            'item_description' => $this->itemDescription,
            'quantity' => $this->quantity,
            'unit_price' => $this->unitPrice,
            'line_total' => $this->getLineTotal(),
            'unit' => $this->unit,
            'invoice_id' => $this->invoiceId,
            'created_at' => $this->createdAt->format('Y-m-d H:i:s'),
        ];
    }
}
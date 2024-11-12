<?php

declare(strict_types=1);

namespace Entity;

class Order
{
    protected int $eventId;
    protected string $eventDate;
    protected int $ticketAdultPrice;
    protected int $ticketAdultQuantity;
    protected int $ticketKidPrice;
    protected int $ticketKidQuantity;
    protected string $barcode;
    protected int $equalPrice;

    public function __construct(
        int $eventId,
        string $eventDate,
        int $ticketAdultPrice,
        int $ticketAdultQuantity,
        int $ticketKidPrice,
        int $ticketKidQuantity,
        string $barcode,
        int $equalPrice
    ) {
        $this->eventId = $eventId;
        $this->eventDate = $eventDate;
        $this->ticketAdultPrice = $ticketAdultPrice;
        $this->ticketAdultQuantity = $ticketAdultQuantity;
        $this->ticketKidPrice = $ticketKidPrice;
        $this->ticketKidQuantity = $ticketKidQuantity;
        $this->barcode = $barcode;
        $this->equalPrice = $equalPrice;
    }

    // Методы для получения значений свойств
    public function getEventId(): int { return $this->eventId; }
    public function getEventDate(): string { return $this->eventDate; }
    public function getTicketAdultPrice(): int { return $this->ticketAdultPrice; }
    public function getTicketAdultQuantity(): int { return $this->ticketAdultQuantity; }
    public function getTicketKidPrice(): int { return $this->ticketKidPrice; }
    public function getTicketKidQuantity(): int { return $this->ticketKidQuantity; }
    public function getBarcode(): string { return $this->barcode; }
    public function getEqualPrice(): int { return $this->equalPrice; }
}
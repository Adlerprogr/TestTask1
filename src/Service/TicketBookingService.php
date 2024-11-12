<?php

declare(strict_types=1);

namespace Service;

use Entity\Order;
use Exceptions\BookingException;
use Repository\OrderRepository;

class TicketBookingService
{
    private ApiService $apiService;
    private OrderRepository $orderRepository;

    public function __construct(ApiService $apiService, OrderRepository $orderRepository)
    {
        $this->apiService = $apiService;
        $this->orderRepository = $orderRepository;
    }

    public function bookTickets(
        int $eventId,
        string $eventDate,
        int $ticketAdultPrice,
        int $ticketAdultQuantity,
        int $ticketKidPrice,
        int $ticketKidQuantity
    ): int {
        $equalPrice = ($ticketAdultPrice * $ticketAdultQuantity) + ($ticketKidPrice * $ticketKidQuantity);
        $barcode = $this->generateAndBookBarcode($eventId, $eventDate, $ticketAdultPrice, $ticketAdultQuantity, $ticketKidPrice, $ticketKidQuantity);

        if (!$this->apiService->approve($barcode)) {
            throw new BookingException("Failed to approve booking");
        }

        $order = new Order($eventId, $eventDate, $ticketAdultPrice, $ticketAdultQuantity, $ticketKidPrice, $ticketKidQuantity, $barcode, $equalPrice);

        $orderId = $this->orderRepository->save($order);

        return $orderId;
    }

    private function generateAndBookBarcode(int $eventId, string $eventDate, int $ticketAdultPrice, int $ticketAdultQuantity, int $ticketKidPrice, int $ticketKidQuantity): string
    {
        $maxAttempts = 5;
        $attempt = 0;

        while ($attempt < $maxAttempts) {
            $barcode = $this->generateBarcode();
            try {
                return $this->apiService->book([
                    'event_id' => $eventId,
                    'event_date' => $eventDate,
                    'ticket_adult_price' => $ticketAdultPrice,
                    'ticket_adult_quantity' => $ticketAdultQuantity,
                    'ticket_kid_price' => $ticketKidPrice,
                    'ticket_kid_quantity' => $ticketKidQuantity,
                    'barcode' => $barcode
                ]);
            } catch (BookingException $e) {
                $attempt++;
            }
        }

        throw new BookingException("Failed to generate a unique barcode after {$maxAttempts} attempts");
    }

    private function generateBarcode(): string
    {
        return str_pad((string)random_int(0, 99999999), 8, '0', STR_PAD_LEFT);
    }
}
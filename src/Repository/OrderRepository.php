<?php

declare(strict_types=1);

namespace Repository;

use Entity\Order;
use Exception;

class OrderRepository extends Repository
{
    /**
     * Сохраняет заказ в базе данных
     *
     * @throws Exception
     */
    public function save(Order $order): int
    {
        // Начало транзакции
        $this->getPdo()->beginTransaction();

        try {
            $stmt = self::getPdo()->prepare("
            INSERT INTO orders (
                event_id, 
                event_date, 
                ticket_adult_price, 
                ticket_adult_quantity,
                ticket_kid_price, 
                ticket_kid_quantity,
                barcode,
                equal_price,
                created
            ) VALUES (
                :event_id, 
                :event_date,
                :ticket_adult_price, 
                :ticket_adult_quantity,
                :ticket_kid_price,
                :ticket_kid_quantity,
                :barcode, 
                :equal_price,
                NOW()
            )
            ");

            $stmt->execute([
                ':event_id' => $order->getEventId(),
                ':event_date' => $order->getEventDate(),
                ':ticket_adult_price' => $order->getTicketAdultPrice(),
                ':ticket_adult_quantity' => $order->getTicketAdultQuantity(),
                ':ticket_kid_price' => $order->getTicketKidPrice(),
                ':ticket_kid_quantity' => $order->getTicketKidQuantity(),
                ':barcode' => $order->getBarcode(),
                ':equal_price' => $order->getEqualPrice()
            ]);

            $id = (int)self::getPdo()->lastInsertId();

            // Фиксация транзакции
            $this->getPdo()->commit();

            return $id;
        } catch (Exception $e) {
            // Откат транзакции в случае ошибки
            $this->getPdo()->rollBack();
            throw $e;
        }
    }
}
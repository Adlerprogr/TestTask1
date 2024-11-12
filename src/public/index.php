<?php

declare(strict_types=1);

use Core\Autoloader;
use Exceptions\BookingException;
use Exceptions\DatabaseException;
use Repository\OrderRepository;
use Service\ApiService;
use Service\Client\ApiClientService;
use Service\TicketBookingService;

require_once './../Core/Autoloader.php';

$dir = dirname(__DIR__);
Autoloader::registration($dir);

/**
 * Пример использования системы бронирования
 */

// Создание подключение к базе данных через PDO
$pdo = (new Repository\Repository())->getPdo();

// Создание экземпляра OrderRepository
$orderRepository = new OrderRepository();

// Создание экземпляра ApiClientService
$apiClientService = new ApiClientService();

// Создание экземпляра ApiService
$apiService = new ApiService($apiClientService);

// Создание сервиса бронирования билетов с нужными зависимостями
$bookingService = new TicketBookingService($apiService, $orderRepository);

try {
    // Бронирование билетов с передачей необходимых параметров
    $orderId = $bookingService->bookTickets(
        eventId: 1,
        eventDate: '2024-11-20',
        ticketAdultPrice: 50,
        ticketAdultQuantity: 2,
        ticketKidPrice: 25,
        ticketKidQuantity: 3
    );

    // Успешный вывод результата
    echo "Order successfully created with ID: $orderId";
} catch (BookingException $e) {
    // Обработка ошибки бронирования
    echo "Booking Error: " . $e->getMessage();
} catch (DatabaseException $e) {
    // Обработка ошибки базы данных
    echo "Database Error: " . $e->getMessage();
} catch (Exception $e) {
    // Обработка других возможных исключений
    echo "An unexpected error occurred: " . $e->getMessage();
}
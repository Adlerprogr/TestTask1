<?php

declare(strict_types=1);

namespace Service;

use Exceptions\BookingException;
use Service\Client\ApiClientService;

class ApiService
{
    private ApiClientService $apiClient;

    public function __construct(ApiClientService $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    /**
     * Бронирование с передачей параметров.
     * @throws BookingException
     */
    public function book(array $data): string
    {
        $response = $this->apiClient->callApi('book', $data);

        if (isset($response['message'])) {
            return $data['barcode'];
        }

        throw new BookingException("Failed to book: " . ($response['error'] ?? 'Unknown error'));
    }

    /**
     * Подтверждение бронирования.
     */
    public function approve(string $barcode): bool
    {
        $response = $this->apiClient->callApi('approve', ['barcode' => $barcode]);
        return isset($response['message']);
    }
}
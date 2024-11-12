<?php

declare(strict_types=1);

namespace Service\Client;

use RuntimeException;

class ApiClientService
{
    private string $apiUrl;

    public function __construct(string $apiUrl = 'https://api.site.com')
    {
        $this->apiUrl = $apiUrl;
    }

    public function callApi(string $endpoint, array $data): array
    {
        // Здесь будет логика для фактического вызова API
        // В данном случае используется mock для тестирования
        if ($endpoint === 'book') {
            return random_int(0, 10) > 2 ? ['message' => 'order successfully booked'] : ['error' => 'barcode already exists'];
        }

        if ($endpoint === 'approve') {
            $possibleResponses = [
                ['message' => 'order successfully approved'],
                ['error' => 'event cancelled'],
                ['error' => 'no tickets'],
                ['error' => 'no seats'],
                ['error' => 'fan removed']
            ];
            return $possibleResponses[random_int(0, 1)];
        }

        throw new RuntimeException("Unknown endpoint: {$endpoint}");
    }
}
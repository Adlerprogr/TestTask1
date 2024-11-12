<?php

declare(strict_types=1);

namespace Exceptions;

use Exception;

class BookingException extends Exception
{
    /**
     * Создает новый экземпляр BookingException
     *
     * @param string $message Сообщение об ошибке
     * @param int $code Код ошибки (необязательно)
     * @param Exception|null $previous Предыдущее исключение (необязательно)
     */
    public function __construct(string $message = "An error occurred during booking", int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
<?php

namespace Exceptions;

use Exception;

class DatabaseException extends Exception
{
    /**
     * Создает новый экземпляр DatabaseException
     *
     * @param string $message Сообщение об ошибке
     * @param int $code Код ошибки (необязательно)
     * @param Exception|null $previous Предыдущее исключение (необязательно)
     */
    public function __construct(string $message = "A database error occurred", int $code = 0, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
<?php

namespace Luma\SecurityComponent\Exception;

use Luma\AuroraDatabase\Model\Aurora;
use Luma\SecurityComponent\Interface\UserInterface;

class InvalidUserModelException extends \Exception
{
    public function __construct(string $userClass, ?\Throwable $previous = null)
    {
        $message = sprintf(
            'The %s class must extend %s and implement %s',
            $userClass,
            Aurora::class,
            UserInterface::class
        );

        parent::__construct($message, 0, $previous);
    }
}
<?php

namespace Luma\SecurityComponent\Exception;

use Luma\AuroraDatabase\Model\Aurora;
use Luma\SecurityComponent\Authentication\Interface\UserInterface;

class InvalidUserModelException extends \Exception
{
    /**
     * @param string $userClass
     * @param array|null $missingAttributes
     *
     * @param \Throwable|null $previous
     */
    public function __construct(string $userClass, array $missingAttributes = null, ?\Throwable $previous = null)
    {
        $message = $missingAttributes
            ? sprintf(
                'Your %s class is missing the required attributes: %s',
                $userClass,
                implode(', ', $missingAttributes)
            )
            : sprintf(
                'The %s class must extend %s and implement %s',
                $userClass,
                Aurora::class,
                UserInterface::class
            );

        parent::__construct($message, 0, $previous);
    }
}
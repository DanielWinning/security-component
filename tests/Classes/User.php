<?php

namespace Luma\Tests\Classes;

use Luma\AuroraDatabase\Attributes\Column;
use Luma\AuroraDatabase\Attributes\Identifier;
use Luma\AuroraDatabase\Attributes\Schema;
use Luma\AuroraDatabase\Attributes\Table;
use Luma\AuroraDatabase\Model\Aurora;
use Luma\SecurityComponent\Interface\UserInterface;

#[Schema('SecurityComponentTest')]
#[Table('User')]
class User extends Aurora implements UserInterface
{
    #[Identifier]
    #[Column('intUserId')]
    protected int $id;

    #[Column('strUsername')]
    private string $username;

    #[Column('strEmailAddress')]
    private string $emailAddress;

    #[Column('dtmCreated')]
    private \DateTimeInterface $created;

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        // TODO: Implement getPassword() method.
    }

    /**
     * @return string
     */
    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }

    /**
     * @inheritDoc
     */
    public static function getUsernameProperty(): string
    {
        return 'username';
    }
}
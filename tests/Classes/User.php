<?php

namespace Luma\Tests\Classes;

use Luma\AuroraDatabase\Attributes\Column;
use Luma\AuroraDatabase\Attributes\Identifier;
use Luma\AuroraDatabase\Attributes\Schema;
use Luma\AuroraDatabase\Attributes\Table;
use Luma\AuroraDatabase\Model\Aurora;
use Luma\SecurityComponent\Attributes\SecurityIdentifier;
use Luma\SecurityComponent\Interface\UserInterface;

#[Schema('SecurityComponentTest')]
#[Table('User')]
class User extends Aurora implements UserInterface
{
    #[Identifier]
    #[Column('intUserId')]
    protected int $id;

    #[SecurityIdentifier]
    #[Column('strUsername')]
    private string $username;

    #[Column('strEmailAddress')]
    private string $emailAddress;

    #[Column('strPassword')]
    private string $password;

    #[Column('dtmCreated')]
    private \DateTimeInterface $created;

    /**
     * @return int
     */
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

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getEmailAddress(): string
    {
        return $this->emailAddress;
    }
}
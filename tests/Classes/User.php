<?php

namespace Luma\Tests\Classes;

use Luma\AuroraDatabase\Attributes\AuroraCollection;
use Luma\AuroraDatabase\Attributes\Column;
use Luma\AuroraDatabase\Attributes\Identifier;
use Luma\AuroraDatabase\Attributes\Schema;
use Luma\AuroraDatabase\Attributes\Table;
use Luma\AuroraDatabase\Utils\Collection;
use Luma\SecurityComponent\Attributes\SecurityIdentifier;
use Luma\SecurityComponent\Authentication\AbstractUser;
use Luma\SecurityComponent\Authentication\Interface\UserInterface;

#[Schema('SecurityComponentTest')]
#[Table('User')]
class User extends AbstractUser implements UserInterface
{
    #[Identifier]
    #[Column('intUserId')]
    protected int $id;

    #[SecurityIdentifier]
    #[Column('strUsername')]
    protected string $username;

    #[Column('strEmailAddress')]
    private string $emailAddress;

    #[Column('strPassword')]
    protected string $password;

    #[Column('dtmCreated')]
    private \DateTimeInterface $created;

    #[AuroraCollection(Role::class, null, 'Security', 'tblRoleUser', 'intRoleId')]
    protected Collection $roles;

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

    /**
     * @return Collection
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }
}
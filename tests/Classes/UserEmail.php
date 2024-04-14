<?php

namespace Luma\Tests\Classes;

use Luma\AuroraDatabase\Attributes\AuroraCollection;
use Luma\AuroraDatabase\Attributes\Column;
use Luma\AuroraDatabase\Attributes\Identifier;
use Luma\AuroraDatabase\Attributes\Schema;
use Luma\AuroraDatabase\Attributes\Table;
use Luma\AuroraDatabase\Model\Aurora;
use Luma\AuroraDatabase\Utils\Collection;
use Luma\SecurityComponent\Attributes\SecurityIdentifier;
use Luma\SecurityComponent\Authentication\AbstractUser;
use Luma\SecurityComponent\Authentication\Interface\UserInterface;
use Luma\SecurityComponent\Authorization\Role;

#[Schema('SecurityComponentTest')]
#[Table('User')]
class UserEmail extends AbstractUser implements UserInterface
{
    #[Identifier]
    #[Column('intUserId')]
    protected int $id;

    #[Column('strUsername')]
    protected string $username;

    #[SecurityIdentifier]
    #[Column('strEmailAddress')]
    private string $emailAddress;

    #[Column('strPassword')]
    protected string $password;

    #[AuroraCollection(Role::class, null, 'Security', 'tblRoleUser', 'intRoleId')]
    protected Collection $roles;

    private \DateTimeInterface $created;

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return Collection
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }
}
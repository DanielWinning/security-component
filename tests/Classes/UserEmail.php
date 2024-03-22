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
class UserEmail extends Aurora implements UserInterface
{
    #[Identifier]
    #[Column('intUserId')]
    protected int $id;

    #[Column('strUsername')]
    private string $username;

    #[SecurityIdentifier]
    #[Column('strEmailAddress')]
    private string $emailAddress;

    #[Column('strPassword')]
    private string $password;

    private \DateTimeInterface $created;

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
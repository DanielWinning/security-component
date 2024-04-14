<?php

namespace Luma\Tests\Classes;

use Luma\AuroraDatabase\Attributes\Schema;
use Luma\AuroraDatabase\Attributes\Table;
use Luma\AuroraDatabase\Utils\Collection;
use Luma\SecurityComponent\Authentication\AbstractUser;
use Luma\SecurityComponent\Authentication\Interface\UserInterface;

#[Schema('SecurityComponentTest')]
#[Table('User')]
class UserMissingAttributes extends AbstractUser implements UserInterface
{
    protected int $id;

    /**
     * @return string
     */
    public function getUsername(): string
    {
       return '';
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return '';
    }

    public function getRoles(): Collection
    {
        // TODO: Implement getRoles() method.
    }
}
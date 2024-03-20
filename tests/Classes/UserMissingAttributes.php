<?php

namespace Luma\Tests\Classes;

use Luma\AuroraDatabase\Attributes\Schema;
use Luma\AuroraDatabase\Attributes\Table;
use Luma\AuroraDatabase\Model\Aurora;
use Luma\SecurityComponent\Interface\UserInterface;

#[Schema('SecurityComponentTest')]
#[Table('User')]
class UserMissingAttributes extends Aurora implements UserInterface
{
    protected int $id;

    public function getUsername(): string
    {
        // TODO: Implement getUsername() method.
    }

    public function getPassword(): string
    {
        // TODO: Implement getPassword() method.
    }
}
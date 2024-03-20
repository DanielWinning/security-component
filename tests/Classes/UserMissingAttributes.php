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
}
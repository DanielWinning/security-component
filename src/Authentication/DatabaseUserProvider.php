<?php

namespace Luma\SecurityComponent\Authentication;

use Luma\AuroraDatabase\Model\Aurora;
use Luma\SecurityComponent\Exception\InvalidUserModelException;
use Luma\SecurityComponent\Interface\UserInterface;
use Luma\SecurityComponent\Interface\UserProviderInterface;

class DatabaseUserProvider implements UserProviderInterface
{
    private Aurora&UserInterface $userClass;

    /**
     * @param string $userClass
     *
     * @throws \Exception
     */
    public function __construct(string $userClass)
    {
        $this->validateUserClass($userClass);

        $this->userClass = new $userClass;
    }

    /**
     * @param int $id
     *
     * @return UserInterface|null
     */
    public function loadById(int $id): ?UserInterface
    {
        return $this->userClass::find($id);
    }

    /**
     * @param string $username
     *
     * @return UserInterface|null
     *
     * @throws \ReflectionException
     */
    public function loadUserByUsername(string $username): UserInterface|null
    {
        return $this->userClass::findBy($this->userClass::getUsernameProperty(), $username);
    }

    /**
     * @param string $userClass
     *
     * @return void
     *
     * @throws InvalidUserModelException
     */
    private function validateUserClass(string $userClass): void
    {
        $isAurora = in_array(Aurora::class, class_parents($userClass));
        $implementsUserInterface = in_array(UserInterface::class, class_implements($userClass));

        if (!$isAurora || !$implementsUserInterface) {
            throw new InvalidUserModelException($userClass);
        }
    }
}
<?php

namespace Luma\SecurityComponent\Authentication;

use Luma\AuroraDatabase\Attributes\Column;
use Luma\AuroraDatabase\Model\Aurora;
use Luma\SecurityComponent\Attributes\Username;
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
     * @throws \ReflectionException|InvalidUserModelException
     */
    public function loadUserByUsername(string $username): UserInterface|null
    {
        return $this->userClass::findBy($this->getUsernameProperty(), $username);
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

    /**
     * @return string
     *
     * @throws InvalidUserModelException|\ReflectionException
     */
    private function getUsernameProperty(): string
    {
        $reflector = new \ReflectionClass($this->userClass);

        foreach ($reflector->getProperties() as $property) {
            $columnAttribute = $property->getAttributes(Column::class)[0] ?? null;
            $usernameAttribute = $property->getAttributes(Username::class)[0] ?? null;

            if ($columnAttribute && $usernameAttribute) {
                return $property->getName();
            }
        }

        throw new InvalidUserModelException($this->userClass::class, [Column::class, Username::class]);
    }
}
<?php

namespace Luma\SecurityComponent\Authentication\Providers;

use Luma\AuroraDatabase\Attributes\Column;
use Luma\AuroraDatabase\Model\Aurora;
use Luma\SecurityComponent\Attributes\SecurityIdentifier;
use Luma\SecurityComponent\Authentication\Interface\UserInterface;
use Luma\SecurityComponent\Authentication\Interface\UserProviderInterface;
use Luma\SecurityComponent\Exception\InvalidUserModelException;
use Luma\SecurityComponent\Session\DatabaseSessionManager;

class DatabaseUserProvider implements UserProviderInterface
{
    private Aurora&UserInterface $userClass;
    private array $associations;

    /**
     * @param string $userClass
     * @param array $associations
     *
     * @throws InvalidUserModelException
     */
    public function __construct(string $userClass, array $associations = [])
    {
        $this->validateUserClass($userClass);
        $this->associations = $associations;

        $this->userClass = new $userClass;
    }

    /**
     * @param int $id
     *
     * @return UserInterface|null
     */
    public function loadById(int $id): ?UserInterface
    {
        $userFromSession = self::getUserFromSession();

        if ($userFromSession && $userFromSession->getId() === $id) {
            return $userFromSession;
        }

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
        $userFromSession = self::getUserFromSession();

        if ($userFromSession) {
            return $userFromSession->getUsername() === $username ? $userFromSession : null;
        }

        $user = $this->userClass::select()->whereIs($this->getUsernameProperty(), $username)->get();

        if (!$user) {
            return null;
        }

        if (empty($this->associations)) {
            return $user;
        }

        return $user->with($this->associations);
    }

    /**
     * @return UserInterface|null
     */
    public function getUserFromSession(): ?UserInterface
    {
        return DatabaseSessionManager::getSessionItem('user');
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
            $usernameAttribute = $property->getAttributes(SecurityIdentifier::class)[0] ?? null;

            if ($columnAttribute && $usernameAttribute) {
                return $property->getName();
            }
        }

        throw new InvalidUserModelException($this->userClass::class, [Column::class, SecurityIdentifier::class]);
    }
}
<?php

declare(strict_types=1);

namespace Luma\SecurityComponent\Command;

use Luma\AuroraDatabase\Utils\Collection;
use Luma\Framework\Classes\Helper\DatabaseConnectionHelper;
use Luma\SecurityComponent\Entity\Permission;
use Luma\SecurityComponent\Entity\Role;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'luma:security:populate', description: 'Populates initial user and security tables')]
class PopulateCommand extends Command
{
    private SymfonyStyle $style;
    private \stdClass $data;

    /**
     * @return void
     *
     * @throws \Exception
     */
    protected function configure(): void
    {
        DatabaseConnectionHelper::connect();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     *
     * @throws \ReflectionException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->style = new SymfonyStyle($input, $output);
        $this->style->title('Executing Populate Security Schema Command');

        if (!$this->getDataPath()) {
            $this->style->error('No security.json file detected');

            return Command::FAILURE;
        }

        $this->data = json_decode(file_get_contents($this->getDataPath()));

        $this->createPermissions();
        $this->createRoles();

        return Command::SUCCESS;
    }

    /**
     * @return void
     *
     * @throws \ReflectionException
     */
    private function createPermissions(): void
    {
        $this->style->section('Creating Permissions');

        foreach ($this->data->permissions as $permission) {
            $existingPermission = Permission::select()->whereIs('handle', $permission->handle)->get();

            if ($existingPermission) {
                $this->style->writeln(sprintf('Skipping existing permission %s', $permission->handle));
                continue;
            }

            Permission::create([
                'name' => $permission->name,
                'handle' => $permission->handle,
            ])->save();

            $this->style->text(sprintf('Added new permission: %s', $permission->handle));
        }
    }

    /**
     * @return void
     *
     * @throws \ReflectionException
     */
    private function createRoles(): void
    {
        $this->style->section('Creating Roles');

        foreach ($this->data->roles as $role) {
            $existingRole = Role::select()->whereIs('handle', $role->handle)->get();

            if ($existingRole) {
                $this->style->text(sprintf('Skipping existing role %s', $role->handle));
                continue;
            }

            $permissions = new Collection();

            foreach ($role->permissions as $permissionHandle) {
                $permission = Permission::select()->whereIs('handle', $permissionHandle)->get();

                if (!$permission) {
                    $this->style->warning(
                        sprintf(
                            'Skipping adding Permission %s to Role %s. Permission does not exist.',
                            $permissionHandle,
                            $role->handle
                        )
                    );
                    continue;
                }

                $permissions->add($permission);
            }

            Role::create([
                'name' => $role->name,
                'handle' => $role->handle,
                'permissions' => $permissions,
            ])->save();

            $this->style->text(sprintf('Added new role: %s', $role->handle));
        }
    }

    /**
     * @return string|null
     */
    protected function getDataPath(): ?string
    {
        $jsonPath = sprintf('%s/data/security.json', dirname(__DIR__, 5));

        return file_exists($jsonPath) ? $jsonPath : null;
    }
}

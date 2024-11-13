<?php

declare(strict_types=1);

namespace Luma\SecurityComponent\Command;

use Luma\Framework\Classes\Helper\DatabaseConnectionHelper;
use Luma\SecurityComponent\Entity\Permission;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'luma:security:populate', description: 'Populates initial user and security tables')]
class PopulateCommand extends Command
{
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
        $style = new SymfonyStyle($input, $output);
        $style->title('Executing Populate Security Schema Command');

        if (!$this->getDataPath()) {
            $style->error('No security.json file detected');

            return Command::FAILURE;
        }

        $populationData = json_decode(file_get_contents($this->getDataPath()));

        $style->section('Creating Permissions');
        foreach ($populationData->permissions as $permission) {
            $existingPermission = Permission::select()->whereIs('handle', $permission->handle)->get();

            if ($existingPermission) {
                $style->text(sprintf('Skipping existing permission %s', $permission->handle));
                continue;
            }

            Permission::create([
                'name' => $permission->name,
                'handle' => $permission->handle,
            ])->save();

            $style->text(sprintf('Added new permission: %s', $permission->handle));
        }

        return Command::SUCCESS;
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

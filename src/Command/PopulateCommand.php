<?php

declare(strict_types=1);

namespace Luma\SecurityComponent\Command;

use Luma\Framework\Classes\Helper\DatabaseConnectionHelper;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'luma:security:populate', description: 'Populates initial user and security tables')]
class PopulateCommand extends Command
{
    private SymfonyStyle $style;

    /**
     * @return void
     *
     * @throws \Exception
     */
    protected function configure(): void
    {
        DatabaseConnectionHelper::connect();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->style = new SymfonyStyle($input, $output);
        $this->style->title('Executing Populate Security Schema Command');

        return Command::SUCCESS;
    }
}

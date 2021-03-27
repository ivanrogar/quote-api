<?php

declare(strict_types=1);

namespace App\Command;

use App\Exception\Repository\CouldNotSaveException;
use App\Fixture\Quotes;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Tools\ToolsException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class InstallCommand
 * @package App\Command
 */
final class InstallCommand extends Command
{
    protected static $defaultName = 'app:install';

    private Quotes $quotes;

    /**
     * InstallCommand constructor.
     * @param Quotes $quotes
     * @param string|null $name
     */
    public function __construct(
        Quotes $quotes,
        string $name = null
    ) {
        parent::__construct($name);
        $this->quotes = $quotes;
    }

    protected function configure()
    {
        $this->setDescription('Install application data');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws NonUniqueResultException
     * @throws CouldNotSaveException
     * @throws ToolsException
     * @SuppressWarnings(Unused)
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->quotes->install();

        return 0;
    }
}

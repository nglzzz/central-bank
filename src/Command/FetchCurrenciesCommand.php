<?php

namespace App\Command;

use App\Message\FetchCurrencyMessage;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'app:fetch-currencies',
    description: 'Getting currencies from API',
)]
final class FetchCurrenciesCommand extends Command
{
    private const SYNC_DAYS_DEFAULT = 180;
    private MessageBusInterface $messageBus;

    public function __construct(MessageBusInterface $messageBus)
    {
        parent::__construct();

        $this->messageBus = $messageBus;
    }

    protected function configure(): void
    {
        $this
            ->addOption('days', null, InputOption::VALUE_REQUIRED, 'How many days to sync', self::SYNC_DAYS_DEFAULT)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $syncDays = $input->getOption('days');

        if ($syncDays < 1) {
            $output->writeln('<error>Invalid sync days</error>');

            return Command::INVALID;
        }

        $output->writeln(
            \sprintf(
                '<info>Currency synchronization for %d days has been successfully registered and will be completed shortly.</info>',
                $syncDays,
            )
        );

        $this->messageBus->dispatch(new FetchCurrencyMessage($syncDays));

        return Command::SUCCESS;
    }
}

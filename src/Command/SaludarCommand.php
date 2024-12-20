<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:saludar',
    description: 'comando que saluda al poner tu nombre',
)]
class SaludarCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
        ->setDescription('Te saluda.')
        ->setHelp('Este comando te permite ser saludado con tu nombre o cualquiera que introduzcas');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Escribe el mensaje inicial
        $io->writeln('Escribe tu nombre y te saludaré:');

        // Solicita el nombre al usuario
        $nombre = $io->ask('¿Cuál es tu nombre?');

        // Saluda al usuario
        $io->success(sprintf('¡Hola %s!', $nombre));

        return Command::SUCCESS;
    }
}

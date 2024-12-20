<?php

namespace App\Command;

use App\Service\PHPMailerService;
use App\Repository\UsuarioRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;

#[AsCommand(
    name: 'app:cambiarcontrasena',
    description: 'Comando para cambiar la contraseña del administrador',
)]
class CambiarcontrasenaCommand extends Command
{
    private UsuarioRepository $UsuarioRepository;
    private UserPasswordHasherInterface $passwordHasher;
    private EntityManagerInterface $entityManager;
    private PHPMailerService $mailerService;

    public function __construct(
        UsuarioRepository $UsuarioRepository,
        UserPasswordHasherInterface $passwordHasher,
        EntityManagerInterface $entityManager,
        PHPMailerService $mailerService
    ) {
        $this->UsuarioRepository = $UsuarioRepository;
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
        $this->mailerService = $mailerService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
        ->setDescription('Cambia la contraseña del admin y envía un correo de notificación.')
        ->setHelp('Este comando te permite cambiar la contraseña del administrador del proyecto y enviar un correo con un PDF adjunto.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->writeln('Has ejecutado el comando para cambiar la contraseña del administrador');

        
        $admin = $this->UsuarioRepository->find(4);

        if (!$admin) {
            $io->error('No se ha encontrado al usuario administrador con id 4.');
            return Command::FAILURE;
        }

        $contrasena = $io->ask('Introduce la nueva contraseña del administrador');

        
        $hashedPassword = $this->passwordHasher->hashPassword($admin, $contrasena);
        $admin->setPassword($hashedPassword);

        
        $this->entityManager->persist($admin);
        $this->entityManager->flush();

        
        $htmlContentForPDF = '<h1>Cambio de Contraseña</h1><p>La contraseña ha sido cambiada .</p>';
        $emailSent = $this->mailerService->sendEmailWithAttachment(
            'admin@example.com',
            'Notificación de cambio de contraseña',
            'Se ha cambiado la contraseña del administrador.',
            'no-reply@example.com',
            $htmlContentForPDF
        );

        if ($emailSent) {
            $io->success('La contraseña del administrador se ha actualizado y se ha enviado el correo con el PDF.');
        } else {
            $io->warning('La contraseña se ha actualizado correctamente, pero no se pudo enviar el correo.');
        }

        return Command::SUCCESS;
    }
}

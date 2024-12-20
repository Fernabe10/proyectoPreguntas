<?php

namespace App\MessageHandler;

use App\Entity\Pregunta;
use App\Message\SendMensaje;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final class SendMensajeHandler
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(SendMensaje $message): void
    {
        $this->tarea();
    }

    public function tarea(): void
    {
        $preguntas = $this->entityManager->getRepository(Pregunta::class)->findAll();
        $fechaActual = new \DateTime();

        foreach ($preguntas as $pregunta) {
            $estadoAnterior = $pregunta->isActivo();
            $fechaInicio = $pregunta->getFechaInicio();
            $fechaFin = $pregunta->getFechaFin();

            
            if ($fechaInicio > $fechaActual) {
                $pregunta->setActivo(false);
            } elseif ($fechaFin < $fechaActual) {
                $pregunta->setActivo(false);
            } else {
                $pregunta->setActivo(true);
            }

            
            if ($pregunta->isActivo() !== $estadoAnterior) {
                $this->entityManager->persist($pregunta);
            }
        }

        
        $this->entityManager->flush();
    }
}

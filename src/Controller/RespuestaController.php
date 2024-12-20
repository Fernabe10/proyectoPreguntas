<?php

namespace App\Controller;

use App\Entity\Pregunta;
use App\Entity\Usuario;
use App\Entity\Respuesta;
use App\Form\RespuestaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class RespuestaController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/pregunta/responder/{id}', name: 'responder_pregunta')]
    public function responderPregunta(int $id, Request $request): Response
    {
    
    $pregunta = $this->entityManager->getRepository(Pregunta::class)->find($id);

    if (!$pregunta) {
        throw $this->createNotFoundException('La pregunta no existe.');
    }

    // verifico si la pregunta está activa
    if (!$pregunta->isActivo()) {
        return $this->render('pregunta/pregunta_inactiva.html.twig');
    }

    
    $usuario = $this->getUser();

    
    $respuestaExistente = $this->entityManager->getRepository(Respuesta::class)->findOneBy([
        'pregunta' => $pregunta,
        'usuario_id' => $usuario->getId(),
    ]);

    
    $fechaActual = new \DateTime();
    if ($respuestaExistente && $respuestaExistente->getFecha() <= $fechaActual) {
        
        return $this->redirectToRoute('pregunta_respondida', ['id' => $respuestaExistente->getId()]);
    }

    
    $respuesta = new Respuesta();
    $form = $this->createForm(RespuestaType::class, $respuesta, [
        'pregunta' => $pregunta,
    ]);

    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $respuesta->setPregunta($pregunta);
        $respuesta->setFecha(new \DateTime());
        $respuesta->setUsuarioId($usuario->getId());

        $this->entityManager->persist($respuesta);
        $this->entityManager->flush();

        return $this->redirectToRoute('pregunta_respondida', ['id' => $respuestaExistente->getId()]);
    }

    return $this->render('respuesta/responder_pregunta.html.twig', [
        'form' => $form->createView(),
        'pregunta' => $pregunta,
    ]);
}


    #[Route('/respuesta/respuesta_enviada/{id}', name: 'pregunta_respondida')]
    public function show(int $id): Response
    {
        $respuesta = $this->entityManager->getRepository(Respuesta::class)->find($id);

        if (!$respuesta) {
            throw $this->createNotFoundException('La respuesta no existe.');
        }

        return $this->render('respuesta/respuesta.html.twig', [
            'respuesta' => $respuesta,
        ]);
    }

}

<?php
namespace App\Controller;

use DateTime;
use App\Entity\Pregunta;
use App\Form\PreguntaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PreguntaController extends AbstractController
{
    //metodo para crear la pregunta

    #[Route('/admin/crearpregunta', name: 'create_pregunta')]
public function createPregunta(Request $request, EntityManagerInterface $entityManager): Response
{
    
    $pregunta = new Pregunta();
    $form = $this->createForm(PreguntaType::class, $pregunta);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $fechaInicio = $pregunta->getFechaInicio();
        $fechaFin = $pregunta->getFechaFin();
        $fechaActual = new \DateTime();

        // validar conflicto de fechas
        $conflicto = $this->ValidarFechas($entityManager, $fechaInicio, $fechaFin);

        if ($conflicto) {
            $this->addFlash('success', 'Este es un mensaje flash de prueba.');
            $this->addFlash('error', 'Ya existe una pregunta activa que coincide con este rango de fechas.');
            return $this->render('pregunta/crear_pregunta.html.twig', [
                'form' => $form->createView(),
            ]);
        }

        
        if ($fechaInicio > $fechaActual) {
            $pregunta->setActivo(false);
        } else {
            $pregunta->setActivo(true);
        }

        $entityManager->persist($pregunta);
        $entityManager->flush();

        return $this->redirectToRoute('ver_admin_preguntas');
    }

    return $this->render('pregunta/crear_pregunta.html.twig', [
        'form' => $form->createView(),
    ]);
}

    //metodo para ver todas las preguntas en una tabla

    #[Route('/pregunta/verpreguntas', name: 'ver_preguntas')]
    public function listarPreguntas(EntityManagerInterface $entityManager): Response
    {
        
        $preguntas = $entityManager->getRepository(Pregunta::class)->findBy(['activo' => true]);

        return $this->render('pregunta/ver_preguntas.html.twig', [
            'preguntas' => $preguntas,
        ]);
}

    //metodo para borrar una pregunta por id

    #[Route('/admin/pregunta/borrar/{id}', name: 'borrar_pregunta')]
    public function delete(int $id, EntityManagerInterface $entityManager): Response
    {
        
        $pregunta = $entityManager->getRepository(Pregunta::class)->find($id);

        
        if (!$pregunta) {
            throw $this->createNotFoundException(
                'No se encontró una pregunta con el ID: ' . $id
            );
        }

        
        $entityManager->remove($pregunta);
        $entityManager->flush();


        return $this->redirectToRoute('ver_admin_preguntas');
    }

    //metodo para editar una pregunta por id

    #[Route('/admin/pregunta/editar/{id}', name: 'editar_pregunta')]
public function modify(int $id, Request $request, EntityManagerInterface $entityManager): Response
{
    $pregunta = $entityManager->getRepository(Pregunta::class)->find($id);

    if (!$pregunta) {
        throw $this->createNotFoundException(
            'No se encontró una pregunta con el ID: ' . $id
        );
    }

    $form = $this->createForm(PreguntaType::class, $pregunta);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $fechaInicio = $pregunta->getFechaInicio();
        $fechaFin = $pregunta->getFechaFin();
        $fechaActual = new DateTime();

        
        if ($fechaInicio <= $fechaActual && $fechaFin > $fechaActual) {
            $pregunta->setActivo(true);
        } else {
            $pregunta->setActivo(false);
        }

        $entityManager->flush();

        return $this->redirectToRoute('ver_admin_preguntas');
    }

    return $this->render('pregunta/editar_pregunta.html.twig', [
        'form' => $form->createView(),
        'pregunta' => $pregunta,
    ]);
}

    #[Route('/admin/pregunta/verpreguntas', name: 'ver_admin_preguntas')]
    public function listarAdminPreguntas(EntityManagerInterface $entityManager): Response
    {
        $preguntas = $entityManager->getRepository(Pregunta::class)->findAll();

        return $this->render('pregunta/ver_admin_preguntas.html.twig', [
            'preguntas' => $preguntas,
        ]);
    }

    //metodo para ver la pregunta por id ADMIN

    #[Route('/admin/pregunta/verpregunta/{id}', name: 'ver_admin_pregunta')]
    public function showAdmin(EntityManagerInterface $entityManager, int $id): Response
    {
        $pregunta = $entityManager->getRepository(Pregunta::class)->find($id);

        if (!$pregunta) {
            throw $this->createNotFoundException(
                'No se encontro una pregunta con el id: '.$id
            );
        }

        return $this->render('pregunta/ver_pregunta.html.twig', ['pregunta' => $pregunta]);
    }


    //funcion para validar la fecha activa o no
    private function ValidarFechas(EntityManagerInterface $entityManager, \DateTimeInterface $fechaInicio, \DateTimeInterface $fechaFin): bool
    {
        $preguntasActivas = $entityManager->getRepository(Pregunta::class)->findBy(['activo' => true]);

        foreach ($preguntasActivas as $pregunta) {
            $inicioExistente = $pregunta->getFechaInicio();
            $finExistente = $pregunta->getFechaFin();

            // Comprobar solapamiento de fechas
            if (
                ($fechaInicio >= $inicioExistente && $fechaInicio <= $finExistente) ||
                ($fechaFin >= $inicioExistente && $fechaFin <= $finExistente) ||      
                ($fechaInicio <= $inicioExistente && $fechaFin >= $finExistente)      
            ) {
                return true;
            }

        }

        return false;
    }

    














    
}
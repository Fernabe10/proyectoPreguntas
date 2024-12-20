<?php
// src/Controller/ApiController.php
namespace App\Controller;

use App\Repository\RespuestaRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiController extends AbstractController
{
    private $respuestaRepository;

    public function __construct(RespuestaRepository $respuestaRepository)
    {
        $this->respuestaRepository = $respuestaRepository;
    }

    #[Route('/pregunta/api/respuestas/{preguntaId}', name: 'api_respuestas', methods: ['GET'])]
    public function getRespuestas(int $preguntaId): JsonResponse
    {
        
        $respuestas = $this->respuestaRepository->findBy(['pregunta' => $preguntaId]);

        if (!$respuestas) {
            return new JsonResponse(['error' => 'No se encontraron respuestas'], 404);
        }

        
        $conteos = [];

        foreach ($respuestas as $respuesta) {
            $textoRespuesta = $respuesta->getRespuesta();
            if (!isset($conteos[$textoRespuesta])) {
                $conteos[$textoRespuesta] = 0;
            }
            $conteos[$textoRespuesta]++;
        }

        
        return new JsonResponse([
            'preguntaId' => $preguntaId,
            'conteos' => $conteos,
        ]);
    }
}

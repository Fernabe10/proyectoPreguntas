<?php
namespace App\Entity;

use App\Repository\RespuestaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RespuestaRepository::class)]
class Respuesta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $usuario_id = null; // Este es el ID del usuario (o puede ser una relación si tienes entidad Usuario)

    #[ORM\ManyToOne(targetEntity: Pregunta::class, inversedBy: 'respuestas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Pregunta $pregunta = null; // Relación con Pregunta

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha = null; // Fecha en que se responde

    #[ORM\Column(length: 200)]
    private ?string $respuesta = null; // Aquí se almacenará la respuesta seleccionada por el usuario

    // Métodos getter y setter

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuarioId(): ?int
    {
        return $this->usuario_id;
    }

    public function setUsuarioId(int $usuario_id): static
    {
        $this->usuario_id = $usuario_id;

        return $this;
    }

    public function getPregunta(): ?Pregunta
    {
        return $this->pregunta;
    }

    public function setPregunta(?Pregunta $pregunta): static
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getRespuesta(): ?string
    {
        return $this->respuesta;
    }

    public function setRespuesta(string $respuesta): static
    {
        $this->respuesta = $respuesta;

        return $this;
    }
}

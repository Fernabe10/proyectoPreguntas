<?php
namespace App\Entity;

use App\Repository\PreguntaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: PreguntaRepository::class)]
class Pregunta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fechaInicio = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fechaFin = null;

    #[ORM\Column]
    private ?bool $activo = null;

    #[ORM\Column(length: 200)]
    private ?string $respuesta1 = null;

    #[ORM\Column(length: 200)]
    private ?string $respuesta2 = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $respuesta3 = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $respuesta4 = null;

    #[ORM\Column(length: 200)]
    private ?string $respuesta_correcta = null;

    #[ORM\OneToMany(mappedBy: 'pregunta', targetEntity: Respuesta::class)]
    private Collection $respuestas;

    public function __construct()
    {
        $this->respuestas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): static
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->fechaInicio;
    }

    public function setFechaInicio(\DateTimeInterface $fechaInicio): static
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    public function getFechaFin(): ?\DateTimeInterface
    {
        return $this->fechaFin;
    }

    public function setFechaFin(\DateTimeInterface $fechaFin): static
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    public function isActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): static
    {
        $this->activo = $activo;

        return $this;
    }

    public function getRespuesta1(): ?string
    {
        return $this->respuesta1;
    }

    public function setRespuesta1(string $respuesta1): static
    {
        $this->respuesta1 = $respuesta1;

        return $this;
    }

    public function getRespuesta2(): ?string
    {
        return $this->respuesta2;
    }

    public function setRespuesta2(string $respuesta2): static
    {
        $this->respuesta2 = $respuesta2;

        return $this;
    }

    public function getRespuesta3(): ?string
    {
        return $this->respuesta3;
    }

    public function setRespuesta3(?string $respuesta3): static
    {
        $this->respuesta3 = $respuesta3;

        return $this;
    }

    public function getRespuesta4(): ?string
    {
        return $this->respuesta4;
    }

    public function setRespuesta4(?string $respuesta4): static
    {
        $this->respuesta4 = $respuesta4;

        return $this;
    }

    public function getRespuestaCorrecta(): ?string
    {
        return $this->respuesta_correcta;
    }

    public function setRespuestaCorrecta(string $respuesta_correcta): static
    {
        $this->respuesta_correcta = $respuesta_correcta;

        return $this;
    }

    public function getRespuestas(): Collection
    {
        return $this->respuestas;
    }
}

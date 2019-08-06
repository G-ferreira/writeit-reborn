<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CapituloRepository")
 */
class Capitulo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $titulo;

    /**
     * @ORM\Column(type="text")
     */
    private $texto;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dataPublicacao;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Historia", inversedBy="capitulos")
     */
    private $idHistoria;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getTexto(): ?string
    {
        return $this->texto;
    }

    public function setTexto(string $texto): self
    {
        $this->texto = $texto;

        return $this;
    }

    public function getDataPublicacao(): ?\DateTimeInterface
    {
        return $this->dataPublicacao;
    }

    public function setDataPublicacao(\DateTimeInterface $dataPublicacao): self
    {
        $this->dataPublicacao = $dataPublicacao;

        return $this;
    }

    public function getIdHistoria(): ?Historia
    {
        return $this->idHistoria;
    }

    public function setIdHistoria(?Historia $idHistoria): self
    {
        $this->idHistoria = $idHistoria;

        return $this;
    }
}

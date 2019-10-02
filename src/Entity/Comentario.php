<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ComentarioRepository")
 */
class Comentario
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Capitulo", inversedBy="comentarios")
     */
    private $idCapitulo;

    /**
     * @ORM\Column(type="text")
     */
    private $texto;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dataPublicacao;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LeitorAutor", inversedBy="capitulos")
     */
    private $idLeitor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCapitulo(): ?Capitulo
    {
        return $this->idCapitulo;
    }

    public function setIdCapitulo(?Capitulo $idCapitulo): self
    {
        $this->idCapitulo = $idCapitulo;

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

    public function getIdLeitor(): ?LeitorAutor
    {
        return $this->idLeitor;
    }

    public function setIdLeitor(?LeitorAutor $idLeitor): self
    {
        $this->idLeitor = $idLeitor;

        return $this;
    }
}

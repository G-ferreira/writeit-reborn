<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\JoinColumn(nullable=false)
     */
    private $idHistoria;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Historico", mappedBy="capitulo")
     */
    private $historicos;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LeitorAutor", inversedBy="capitulos")
     */
    private $idAutor;
    

    public function __construct()
    {
        $this->historicos = new ArrayCollection();
    }

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

    /**
     * @return Collection|Historico[]
     */
    public function getHistoricos(): Collection
    {
        return $this->historicos;
    }

    public function addHistorico(Historico $historico): self
    {
        if (!$this->historicos->contains($historico)) {
            $this->historicos[] = $historico;
            $historico->addCapitulo($this);
        }

        return $this;
    }

    public function removeHistorico(Historico $historico): self
    {
        if ($this->historicos->contains($historico)) {
            $this->historicos->removeElement($historico);
            $historico->removeCapitulo($this);
        }

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getIdAutor(): ?LeitorAutor
    {
        return $this->idAutor;
    }

    public function setIdAutor(?LeitorAutor $idAutor): self
    {
        $this->idAutor = $idAutor;

        return $this;
    }
}

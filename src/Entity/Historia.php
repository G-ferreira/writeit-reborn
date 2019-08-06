<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HistoriaRepository")
 */
class Historia
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
    private $sinopse;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $classificacao;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AutorLeitor", inversedBy="historias")
     */
    private $idAutor;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Categoria", inversedBy="historias")
     */
    private $idCategoria;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Genero", inversedBy="historias")
     */
    private $idGenero;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Capitulo", mappedBy="idHistoria")
     */
    private $capitulos;

    public function __construct()
    {
        $this->idCategoria = new ArrayCollection();
        $this->idGenero = new ArrayCollection();
        $this->capitulos = new ArrayCollection();
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

    public function getSinopse(): ?string
    {
        return $this->sinopse;
    }

    public function setSinopse(string $sinopse): self
    {
        $this->sinopse = $sinopse;

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

    public function getClassificacao(): ?string
    {
        return $this->classificacao;
    }

    public function setClassificacao(string $classificacao): self
    {
        $this->classificacao = $classificacao;

        return $this;
    }

    public function getIdAutor(): ?AutorLeitor
    {
        return $this->idAutor;
    }

    public function setIdAutor(?AutorLeitor $idAutor): self
    {
        $this->idAutor = $idAutor;

        return $this;
    }

    /**
     * @return Collection|Categoria[]
     */
    public function getIdCategoria(): Collection
    {
        return $this->idCategoria;
    }

    public function addIdCategorium(Categoria $idCategorium): self
    {
        if (!$this->idCategoria->contains($idCategorium)) {
            $this->idCategoria[] = $idCategorium;
        }

        return $this;
    }

    public function removeIdCategorium(Categoria $idCategorium): self
    {
        if ($this->idCategoria->contains($idCategorium)) {
            $this->idCategoria->removeElement($idCategorium);
        }

        return $this;
    }

    /**
     * @return Collection|Genero[]
     */
    public function getIdGenero(): Collection
    {
        return $this->idGenero;
    }

    public function addIdGenero(Genero $idGenero): self
    {
        if (!$this->idGenero->contains($idGenero)) {
            $this->idGenero[] = $idGenero;
        }

        return $this;
    }

    public function removeIdGenero(Genero $idGenero): self
    {
        if ($this->idGenero->contains($idGenero)) {
            $this->idGenero->removeElement($idGenero);
        }

        return $this;
    }

    /**
     * @return Collection|Capitulo[]
     */
    public function getCapitulos(): Collection
    {
        return $this->capitulos;
    }

    public function addCapitulo(Capitulo $capitulo): self
    {
        if (!$this->capitulos->contains($capitulo)) {
            $this->capitulos[] = $capitulo;
            $capitulo->setIdHistoria($this);
        }

        return $this;
    }

    public function removeCapitulo(Capitulo $capitulo): self
    {
        if ($this->capitulos->contains($capitulo)) {
            $this->capitulos->removeElement($capitulo);
            // set the owning side to null (unless already changed)
            if ($capitulo->getIdHistoria() === $this) {
                $capitulo->setIdHistoria(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;

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
     * @ORM\Column(type="string", length=255)
     */
    private $classificacao;

    /**
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LeitorAutor", inversedBy="historias")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idAutor;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Capitulo", mappedBy="idHistoria")
     */
    private $capitulos;

    /**
     * @ORM\Column(type="date")
     */
    private $data_publicacao;

    /**
     * @ORM\Column(type="boolean")
     */
    private $rascunho;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Genero", mappedBy="historias")
     */
    private $generos;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Categoria", mappedBy="historias")
     */
    private $categorias;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Avaliacao", mappedBy="idHistoria")
     */
    private $avaliacaos;

    public function __construct()
    {
        $this->categoria = new ArrayCollection();
        $this->genero = new ArrayCollection();
        $this->capitulos = new ArrayCollection();
        $this->data_publicacao = new \DateTime();
        $this->generos = new ArrayCollection();
        $this->categorias = new ArrayCollection();
        $this->avaliacaos = new ArrayCollection();
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

    public function getIdAutor(): ?LeitorAutor
    {
        return $this->idAutor;
    }

    public function setIdAutor(?LeitorAutor $idAutor): self
    {
        $this->idAutor = $idAutor;

        return $this;
    }

    public function __toString(){
        // to show the name of the Category in the select
        return $this->titulo;
        // to show the id of the Category in the select
        // return $this->id;
    }

    public function getDataPublicacao(): ?\DateTimeInterface
    {
        return $this->data_publicacao;
    }

    public function setDataPublicacao(\DateTimeInterface $data_publicacao): self
    {
        $this->data_publicacao = $data_publicacao;

        return $this;
    }

    public function getRascunho(): ?bool
    {
        return $this->rascunho;
    }

    public function setRascunho(bool $rascunho): self
    {
        $this->rascunho = $rascunho;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Genero[]
     */
    public function getGeneros(): Collection
    {
        return $this->generos;
    }

    public function addGenero(Genero $genero): self
    {
        if (!$this->generos->contains($genero)) {
            $this->generos[] = $genero;
            $genero->addHistoria($this);
        }

        return $this;
    }

    public function removeGenero(Genero $genero): self
    {
        if ($this->generos->contains($genero)) {
            $this->generos->removeElement($genero);
            $genero->removeHistoria($this);
        }

        return $this;
    }

    /**
     * @return Collection|Categoria[]
     */
    public function getCategorias(): Collection
    {
        return $this->categorias;
    }

    public function addCategoria(Categoria $categoria): self
    {
        if (!$this->categorias->contains($categoria)) {
            $this->categorias[] = $categoria;
            $categoria->addHistoria($this);
        }

        return $this;
    }

    public function removeCategoria(Categoria $categoria): self
    {
        if ($this->categorias->contains($categoria)) {
            $this->categorias->removeElement($categoria);
            $categoria->removeHistoria($this);
        }

        return $this;
    }

    /**
     * @return Collection|Avaliacao[]
     */
    public function getAvaliacaos(): Collection
    {
        return $this->avaliacaos;
    }

    public function addAvaliacao(Avaliacao $avaliacao): self
    {
        if (!$this->avaliacaos->contains($avaliacao)) {
            $this->avaliacaos[] = $avaliacao;
            $avaliacao->setIdHistoria($this);
        }

        return $this;
    }

    public function removeAvaliacao(Avaliacao $avaliacao): self
    {
        if ($this->avaliacaos->contains($avaliacao)) {
            $this->avaliacaos->removeElement($avaliacao);
            // set the owning side to null (unless already changed)
            if ($avaliacao->getIdHistoria() === $this) {
                $avaliacao->setIdHistoria(null);
            }
        }

        return $this;
    }
}

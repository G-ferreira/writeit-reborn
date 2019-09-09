<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HistoricoRepository")
 */
class Historico
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\LeitorAutor", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $autor;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Capitulo", inversedBy="historicos")
     */
    private $capitulo;

    public function __construct()
    {
        $this->capitulo = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAutor(): ?LeitorAutor
    {
        return $this->autor;
    }

    public function setAutor(LeitorAutor $autor): self
    {
        $this->autor = $autor;

        return $this;
    }

    /**
     * @return Collection|Capitulo[]
     */
    public function getCapitulo(): Collection
    {
        return $this->capitulo;
    }

    public function addCapitulo(Capitulo $capitulo): self
    {
        if (!$this->capitulo->contains($capitulo)) {
            $this->capitulo[] = $capitulo;
        }

        return $this;
    }

    public function removeCapitulo(Capitulo $capitulo): self
    {
        if ($this->capitulo->contains($capitulo)) {
            $this->capitulo->removeElement($capitulo);
        }

        return $this;
    }
}

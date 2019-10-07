<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AvaliacaoRepository")
 */
class Avaliacao
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Historia", inversedBy="avaliacaos")
     */
    private $idHistoria;

    /**
     * @ORM\Column(type="float")
     */
    private $voto;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\LeitorAutor", inversedBy="avaliacaos")
     */
    private $idLeitor;

    public function __construct()
    {
        $this->idLeitor = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getVoto(): ?float
    {
        return $this->voto;
    }

    public function setVoto(float $voto): self
    {
        $this->voto = $voto;

        return $this;
    }

    public function getIdLeitor(): ArrayCollection
    {
        return $this->idLeitor;
    }

    public function setIdLeitor(?LeitorAutor $idLeitor): self
    {
        $this->idLeitor = $idLeitor;

        return $this;
    }
}

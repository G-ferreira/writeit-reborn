<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AutorLeitorRepository")
 */
class AutorLeitor
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
    private $nome;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $senha;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Historia", mappedBy="idAutor")
     */
    private $historias;

    public function __construct()
    {
        $this->historias = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getSenha(): ?string
    {
        return $this->senha;
    }

    public function setSenha(string $senha): self
    {
        $this->senha = $senha;

        return $this;
    }

    /**
     * @return Collection|Historia[]
     */
    public function getHistorias(): Collection
    {
        return $this->historias;
    }

    public function addHistoria(Historia $historia): self
    {
        if (!$this->historias->contains($historia)) {
            $this->historias[] = $historia;
            $historia->setIdAutor($this);
        }

        return $this;
    }

    public function removeHistoria(Historia $historia): self
    {
        if ($this->historias->contains($historia)) {
            $this->historias->removeElement($historia);
            // set the owning side to null (unless already changed)
            if ($historia->getIdAutor() === $this) {
                $historia->setIdAutor(null);
            }
        }

        return $this;
    }
}
<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DenunciaRepository")
 */
class Denuncia
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $texto;

    /**
     * @ORM\Column(type="string")
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     */
    private $idHistoria;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * @param mixed $texto
     */
    public function setTexto($texto): void
    {
        $this->texto = $texto;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(string $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getIdHistoria(): ?int
    {
        return $this->idHistoria;
    }

    public function setIdHistoria(int $idHistoria): self
    {
        $this->idHistoria = $idHistoria;

        return $this;
    }


}
<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LeitorAutorRepository")
 * @UniqueEntity("email")
 */
class LeitorAutor implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(max=64)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Historia", mappedBy="idAutor")
     */
    private $historias;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $apelido;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\DadosPagamento", mappedBy="idAutorLeitor", cascade={"persist", "remove"})
     */
    private $dadosPagamento;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Capitulo", mappedBy="idAutor", cascade={"persist", "remove"})
     */
    private $capitulo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Capitulo", mappedBy="idAutor")
     */
    private $capitulos;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    public function __construct()
    {
        $this->historias = new ArrayCollection();
        $this->capitulos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getApelido(): ?string
    {
        return $this->apelido;
    }

    public function setApelido(string $apelido): self
    {
        $this->apelido = $apelido;

        return $this;
    }

    public function getDadosPagamento(): ?DadosPagamento
    {
        return $this->dadosPagamento;
    }

    public function setDadosPagamento(?DadosPagamento $dadosPagamento): self
    {
        $this->dadosPagamento = $dadosPagamento;

        // set (or unset) the owning side of the relation if necessary
        $newIdAutorLeitor = $dadosPagamento === null ? null : $this;
        if ($newIdAutorLeitor !== $dadosPagamento->getIdAutorLeitor()) {
            $dadosPagamento->setIdAutorLeitor($newIdAutorLeitor);
        }

        return $this;
    }

    public function getCapitulo(): ?Capitulo
    {
        return $this->capitulo;
    }

    public function setCapitulo(?Capitulo $capitulo): self
    {
        $this->capitulo = $capitulo;

        // set (or unset) the owning side of the relation if necessary
        $newIdAutor = $capitulo === null ? null : $this;
        if ($newIdAutor !== $capitulo->getIdAutor()) {
            $capitulo->setIdAutor($newIdAutor);
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
            $capitulo->setIdAutor($this);
        }

        return $this;
    }

    public function removeCapitulo(Capitulo $capitulo): self
    {
        if ($this->capitulos->contains($capitulo)) {
            $this->capitulos->removeElement($capitulo);
            // set the owning side to null (unless already changed)
            if ($capitulo->getIdAutor() === $this) {
                $capitulo->setIdAutor(null);
            }
        }

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
}

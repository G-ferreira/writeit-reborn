<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DadosPagamentoRepository")
 */
class DadosPagamento
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $valor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numeroConta;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $agencia;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $banco;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cpf;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\LeitorAutor", inversedBy="dadosPagamento", cascade={"persist", "remove"})
     */
    private $idAutorLeitor;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValor(): ?float
    {
        return $this->valor;
    }

    public function setValor(float $valor): self
    {
        $this->valor = $valor;

        return $this;
    }

    public function getNumeroConta(): ?string
    {
        return $this->numeroConta;
    }

    public function setNumeroConta(string $numeroConta): self
    {
        $this->numeroConta = $numeroConta;

        return $this;
    }

    public function getAgencia(): ?string
    {
        return $this->agencia;
    }

    public function setAgencia(string $agencia): self
    {
        $this->agencia = $agencia;

        return $this;
    }

    public function getBanco(): ?string
    {
        return $this->banco;
    }

    public function setBanco(string $banco): self
    {
        $this->banco = $banco;

        return $this;
    }

    public function getCpf(): ?string
    {
        return $this->cpf;
    }

    public function setCpf(string $cpf): self
    {
        $this->cpf = $cpf;

        return $this;
    }

    public function getIdAutorLeitor(): ?LeitorAutor
    {
        return $this->idAutorLeitor;
    }

    public function setIdAutorLeitor(?LeitorAutor $idAutorLeitor): self
    {
        $this->idAutorLeitor = $idAutorLeitor;

        return $this;
    }

    /**
     * @return Collection|Contribuicao[]
     */
    public function getContribuicaos(): Collection
    {
        return $this->contribuicaos;
    }

    public function addContribuicao(Contribuicao $contribuicao): self
    {
        if (!$this->contribuicaos->contains($contribuicao)) {
            $this->contribuicaos[] = $contribuicao;
            $contribuicao->setDadosPagamento($this);
        }

        return $this;
    }

    public function removeContribuicao(Contribuicao $contribuicao): self
    {
        if ($this->contribuicaos->contains($contribuicao)) {
            $this->contribuicaos->removeElement($contribuicao);
            // set the owning side to null (unless already changed)
            if ($contribuicao->getDadosPagamento() === $this) {
                $contribuicao->setDadosPagamento(null);
            }
        }

        return $this;
    }
}

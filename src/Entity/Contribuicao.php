<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContribuicaoRepository")
 */
class Contribuicao
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idAutor;

    /**
     * @ORM\Column(type="integer")
     */
    private $idPagador;

    /**
     * @ORM\Column(type="float")
     */
    private $valor;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numeroCartao;

    /**
     * @ORM\Column(type="string")
     */
    private $dataVencimento;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cvv;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomeTitular;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $cpf;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nomePagador;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nomeAutor;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getIdAutor()
    {
        return $this->idAutor;
    }

    /**
     * @param mixed $idAutor
     */
    public function setIdAutor($idAutor): void
    {
        $this->idAutor = $idAutor;
    }

    public function getIdPagador(): ?int
    {
        return $this->idPagador;
    }

    public function setIdPagador(int $idPagador): self
    {
        $this->idPagador = $idPagador;

        return $this;
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

    public function getNumeroCartao(): ?string
    {
        return $this->numeroCartao;
    }

    public function setNumeroCartao(string $numeroCartao): self
    {
        $this->numeroCartao = $numeroCartao;

        return $this;
    }

    public function getDataVencimento(): ?string
    {
        return $this->dataVencimento;
    }

    public function setDataVencimento(string $dataVencimento): self
    {
        $this->dataVencimento = $dataVencimento;

        return $this;
    }

    public function getCvv(): ?string
    {
        return $this->cvv;
    }

    public function setCvv(string $cvv): self
    {
        $this->cvv = $cvv;

        return $this;
    }

    public function getNomeTitular(): ?string
    {
        return $this->nomeTitular;
    }

    public function setNomeTitular(string $nomeTitular): self
    {
        $this->nomeTitular = $nomeTitular;

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

    public function getNomePagador(): ?string
    {
        return $this->nomePagador;
    }

    public function setNomePagador(string $nomePagador): self
    {
        $this->nomePagador = $nomePagador;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getNomeAutor()
    {
        return $this->nomeAutor;
    }

    /**
     * @param mixed $nomeAutor
     */
    public function setNomeAutor($nomeAutor): void
    {
        $this->nomeAutor = $nomeAutor;
    }

}

<?php


namespace App\Controller;


use App\Entity\Genero;
use App\Repository\GeneroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GeneroController implements \JsonSerializable
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    private $repository;

    public function __construct(
        EntityManagerInterface $entityManager,
        GeneroRepository $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    /**
     * @Route("/generos", methods={"GET"})
     */
    public function buscarTodos(): Response
    {
        $generoList = $this->repository->findAll();
        return new JsonResponse($generoList);
    }

    /**
     * @Route("/generos/{id}", methods={"GET"})
     */
    public function buscarPorId(int $id): Response
    {
        return new JsonResponse($this->repository->find($id));
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'titulo' => $this->getTitulo(),
            'descricao' => $this->getDescricao()
        ];
    }
}
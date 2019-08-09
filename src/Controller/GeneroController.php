<?php

namespace App\Controller;

use App\Repository\GeneroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GeneroController extends AbstractController
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
        return $this->render('genero/index.html.twig', [
            'lista' => $generoList,
        ]);
    }

    /**
     * @Route("/generos/{id}", methods={"GET"})
     */
    public function buscarPorId(int $id): Response
    {
        return new JsonResponse($this->repository->find($id));
    }
}

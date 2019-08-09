<?php

namespace App\Controller;

use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriaController extends AbstractController
{

    public function __construct(
        EntityManagerInterface $entityManager,
        CategoriaRepository $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    /**
     * @Route("/categorias", methods={"GET"})
     */
    public function buscarTodos(): Response
    {
        $categoriaList = $this->repository->findAll();
        return $this->render('categoria/index.html.twig', [
            'lista' => $categoriaList,
        ]);
    }

    /**
     * @Route("/categorias/{id}", methods={"GET"})
     */
    public function buscarPorId(int $id): Response
    {
        return new JsonResponse($this->repository->find($id));
    }
}

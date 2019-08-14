<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriaController extends AbstractController
{

    public function __construct(
        EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/categorias", methods={"GET"})
     */
    public function buscarTodos(): Response
    {
        $categoriaList = $this->entityManager->getRepository(Categoria::class)->findAll();
        return $this->render('categoria/index.html.twig', [
            'lista' => $categoriaList,
        ]);
    }

    /**
     * @Route("/categorias/{id}", methods={"GET"})
     */
    public function buscarPorId(int $id): Response
    {
        return new JsonResponse($this->entityManager->getRepository(Categoria::class)->find($id));
    }
}

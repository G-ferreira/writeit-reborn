<?php

namespace App\Controller;

use App\Entity\Genero;
use App\Entity\Historia;
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

    public function __construct(
        EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/generos", methods={"GET"})
     */
    public function buscarTodos(): Response
    {
        $generoList = $this->entityManager->getRepository(Genero::class)->findAll();
        return $this->render('genero/index.html.twig', [
            'lista' => $generoList,
        ]);
    }

    /**
     * @Route("/generos/{id}", methods={"GET"})
     */
    public function buscarPorId(int $id): Response
    {
        $historias = $this->entityManager->getRepository(Historia::class)->findAll();

        return $this->render('genero/generos-historias.html.twig', [
            'historias' => $historias
        ]);
    }
}

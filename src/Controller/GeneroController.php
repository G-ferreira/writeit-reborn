<?php

namespace App\Controller;

use App\Entity\Genero;
use App\Entity\Historia;
use App\Repository\GeneroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;
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

        return $this->render('categoria/categorias-historias.html.twig', [
            'historias' => $historias
        ]);
    }

    /**
     * @Route("/generos/id/5", methods={"GET"})
     */
    public function buscarGenero(): Response
    {
//        $historias = $this->entityManager->getRepository(Historia::class)->findAll();

        $id = 5;

        $em = $this->entityManager;
//        $qb = $em->createQuery("SELECT h FROM \App\Entity\Historia h Join:WITH \App\Entity\Genero g ON h.id=g.id WHERE h.id=5");
        $qb=$em->createQueryBuilder();

        $qb->select('h')
           ->from('App\Entity\Historia','h')
            ->innerJoin('h.historias','g','WITH','g.id = :genero_id')
            ->setParameter('genero_id',$id);
//        $result = $qb->getResult();


        return $this->render('categoria/categorias-historias.html.twig', [
            'historias' => $qb
        ]);
    }

    /**
     * @Route("/generos/json/id", methods={"GET"})
     */
    public function buscarGeneroJson(): Response
    {
//        $historias = $this->entityManager->getRepository(Historia::class)->findAll();

        $id=5;

        $em = $this->entityManager;
        $qb=$em->createQueryBuilder()
            ->select('h','g')
            ->from('App\Entity\Genero','g')
            ->leftJoin('g.idGenero','h')
            ->where('g = :id')
            ->setParameter('id',$id);

        $qb->getQuery()->getResult();


        return new JsonResponse($qb);
    }


}

<?php

namespace App\Controller;

use App\Entity\Genero;
use App\Entity\Historia;
use App\Form\GeneroFormType;
use App\Repository\GeneroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\Expr\Join;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/admin/generos", methods={"GET"}, name="adminGeneros")
     */
    public function listaGeneros()
    {
        $generoList = $this->entityManager->getRepository(Genero::class)->findAll();
        return $this->render('genero/lista-generos.html.twig',[
            'lista' => $generoList
        ]);
    }


    /**
     * @Route("/generos/delete/{id}")
     */
    public function delete(int $id)
    {
        $genero =  $this->entityManager->getRepository(Genero::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($genero);
        $entityManager->flush();

        return $this->redirectToRoute('adminGeneros');
    }

    /**
     * @Route("/admin/generos/create")
     */
    public function create(Request $request)
    {
        $genero = new Genero();

        $form = $this->createForm(GeneroFormType::class,$genero);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($genero);
            $entityManager->flush();

            return $this->redirectToRoute('adminGeneros');
        }
        return $this->render('genero/genero-form.html.twig',[
            'form' => $form->createView()
        ]);
    }
}

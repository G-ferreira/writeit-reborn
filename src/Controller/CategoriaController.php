<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Entity\Historia;
use App\Form\CategoriaFormType;
use App\Repository\CategoriaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class CategoriaController extends AbstractController
{

    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->security = $security;
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
        $historias = $this->entityManager->getRepository(Historia::class)->findAll();

        return $this->render('categoria/categorias-historias.html.twig', [
            'historias' => $historias
        ]);
    }

    /**
     * @Route("/categorias/delete/{id}")
     */
    public function delete(int $id)
    {
        $categoria =  $this->entityManager->getRepository(Categoria::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($categoria);
        $entityManager->flush();

        return $this->redirectToRoute('adminCategorias');
    }

    /**
     * @Route("/admin/categorias/create")
     */
    public function create(Request $request)
    {
        $categoria = new Categoria();

        $form = $this->createForm(CategoriaFormType::class,$categoria);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categoria);
            $entityManager->flush();

            return $this->redirectToRoute('adminCategorias');
        }
        return $this->render('categoria/categoria-form.html.twig',[
            'form' => $form->createView()
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Entity\Genero;
use App\Entity\Historia;
use App\Entity\LeitorAutor;
use App\Service\AutorLeitorService\AutorLeitorData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\LeitorAutorLoginFormType;
use Symfony\Component\Security\Core\Security;

class AdminController extends AbstractController
{
    private $autorLeitorData;
    private $security;
    private $entityManager;

    public function __construct(AutorLeitorData $autorLeitorData, Security $security,EntityManagerInterface $entityManager)
    {
        $this->autorLeitorData = $autorLeitorData;
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/autores")
     */
    public function buscarAutores()
    {
        $user = $this->security->getUser();
        if(!$user){
            return $this->redirectToRoute('home');
        }
        if($user->getSMFA() == null){
            return $this->redirectToRoute('home');
        }
        $autores = $this->entityManager->getRepository(LeitorAutor::class)->findAll();
        return $this->render('autorLeitor/autores-admin.html.twig', [
            'lista' => $autores
        ]);
    }

    /**
     * @Route("/admin", name="adminHome")
     */
    public function indexAdmin()
    {
        $user = $this->security->getUser();
        if(!$user){
            return $this->redirectToRoute('home');
        }
        if($user->getSMFA() == null){
            return $this->redirectToRoute('home');
        }
        $autores = $this->entityManager->getRepository(LeitorAutor::class)->findAll();

        $historias = $this->entityManager->getRepository(Historia::class)->findAll();

        return $this->render('index/index-admin.html.twig',[
            'autores' => $autores,
            'historias' => $historias
        ]);
    }

    /**
     * @Route("/admin/categorias", methods={"GET"}, name="adminCategorias")
     */
    public function listaCategorias()
    {
        $user = $this->security->getUser();
        if(!$user){
            return $this->redirectToRoute('home');
        }
        if($user->getSMFA() == null){
            return $this->redirectToRoute('home');
        }
        $categoriaList = $this->entityManager->getRepository(Categoria::class)->findAll();
        return $this->render('categoria/lista-categorias.html.twig',[
            'lista' => $categoriaList
        ]);
    }

    /**
     * @Route("/admin/generos", methods={"GET"}, name="adminGeneros")
     */
    public function listaGeneros()
    {
        $user = $this->security->getUser();
        if(!$user){
            return $this->redirectToRoute('home');
        }
        if($user->getSMFA() == null){
            return $this->redirectToRoute('home');
        }
        $generoList = $this->entityManager->getRepository(Genero::class)->findAll();
        return $this->render('genero/lista-generos.html.twig',[
            'lista' => $generoList
        ]);
    }
}

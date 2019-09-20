<?php

namespace App\Controller;

use App\Entity\Capitulo;
use App\Entity\Genero;
use App\Entity\Historia;
use App\Entity\LeitorAutor;
use App\Form\HistoriaAtualizaFormType;
use App\Form\HistoriaCadastroType;
use App\Service\AutorLeitorService\AutorLeitorData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;


class HistoriaController extends AbstractController
{
    private $entityManager;
    private $autorLeitorData;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, AutorLeitorData $autorLeitorData, Security $security)
    {
        $this->autorLeitorData = $autorLeitorData;
        $this->security = $security;
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/historia", name="historia")
     */
    public function index()
    {
        return $this->render('historia/index.html.twig', [
            'controller_name' => 'HistoriaController',
        ]);
    }

    /**
     * @Route("/historia/create", name="historiaCreate")
     */
    public function create(Request $request)
    {
        $user = $this->security->getUser();
        if(!$user){
            return $this->redirectToRoute('home');
        }

        $historia = new Historia();

        $form = $this->createForm(HistoriaCadastroType::class,$historia);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $classif = $form->get('classificacao')->getData();
            $historia->setClassificacao($classif);

            $historia->setIdAutor($user);

            $entityManager->persist($historia);
            $entityManager->flush();

            return $this->redirectToRoute('create');
        }

        return $this->render('historia/historia.html.twig',[
           'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/historias", name="historias")
     */
    public function list()
    {
        $historias = $this->entityManager->getRepository(Historia::class)->findAll();

        return $this->render('historia/historiaslist.html.twig', [
            'historias' => $historias
        ]);
    }

    /**
     * @Route("/myHistorias", name="myHistorias")
     */
    public function myList()
    {
        $user = $this->security->getUser();
        if(!$user){
            return $this->redirectToRoute('home');
        }

        $historias = $this->entityManager->getRepository(Historia::class)->findBy(["idAutor" => $user->getId()]);

        return $this->render('historia/historiaslist.html.twig', [
            'historias' => $historias
        ]);
    }

    /**
     * @Route("/historia/{id}", name="historiaPorId")
     */
    public function historiaHome(int $id)
    {
        $historia = $this->entityManager->getRepository(Historia::class)->find($id);

        $autor = $historia->getIdAutor();

        $nome_autor = $autor->getApelido();

        $capitulos = $this->entityManager->getRepository(Capitulo::class)->findBy(["idHistoria" => $id]);

        return $this->render('historia/index.html.twig', [
            'historia' => $historia,
            'capitulos' =>$capitulos,
            'nome_autor' => $nome_autor,
            'autor' => $autor
        ]);
    }

    /**
     * @Route("/historia/update/{id}", name="updateHistoria")
     */
    public function update(Request $request, int $id)
    {
        $user = $this->security->getUser();

        $historia = $this->entityManager->getRepository(Historia::class)->find($id);

        if ($user == $historia->getIdAutor()){
            $form = $this->createForm(HistoriaAtualizaFormType::class,$historia);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid())
            {
                $entityManager = $this->getDoctrine()->getManager();

                $entityManager->flush();

                return $this->redirectToRoute('myHistorias');
            }

            return $this->render('historia/historia-atualiza.html.twig',[
                'form' => $form->createView()
            ]);
        }else{
            return $this->redirectToRoute('home');
        }

    }

    /**
     * @Route("/historia/show/{id}", name="showHistoria")
     */
    public function show(int $id)
    {
        $user = $this->security->getUser();

        $historia = $this->entityManager->getRepository(Historia::class)->find($id);

        $autor = $historia->getIdAutor();

        $nome_autor = $autor->getApelido();

        $capitulos = $this->entityManager->getRepository(Capitulo::class)->findBy(["idHistoria" => $id]);

        if ($user == $historia->getIdAutor()){

            return $this->render('historia/historia-autor.html.twig',[
                'historia' => $historia,
                'capitulos' => $capitulos,
                'nome_autor' => $nome_autor,
                'autor' => $autor
            ]);
        }else{
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/historia/delete/{id}", name="deleteHistoria")
     */
    public function delete(int $id)
    {
        $user = $this->security->getUser();

        $historia = $this->entityManager->getRepository(Historia::class)->find($id);

        $capitulos = $this->entityManager->getRepository(Capitulo::class)->findBy(["idHistoria" => $id]);

        if ($user == $historia->getIdAutor()){

            $entityManager = $this->getDoctrine()->getManager();

            foreach ($capitulos as $capitulo){
                $entityManager->remove($capitulo);
            }

            $entityManager->remove($historia);
            $entityManager->flush();

            return $this->redirectToRoute('myHistorias');
        }else{
            return $this->redirectToRoute('home');
        }
    }
}

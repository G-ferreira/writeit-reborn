<?php

namespace App\Controller;

use App\Entity\Capitulo;
use App\Entity\Historia;
use App\Entity\LeitorAutor;
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
            $historia->setIdAutor($user);

            $entityManager->persist($historia);
            $entityManager->flush();

            return $this->redirectToRoute('home');
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

        $capitulos = $this->entityManager->getRepository(Capitulo::class)->findBy(["idHistoria" => $id]);

        return $this->render('historia/index.html.twig', [
            'historia' => $historia,
            'capitulos' =>$capitulos
        ]);
    }
}

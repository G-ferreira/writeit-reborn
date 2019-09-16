<?php

namespace App\Controller;

use App\Entity\Capitulo;
use App\Entity\Historia;
use App\Entity\Historico;
use App\Entity\LeitorAutor;
use App\Form\CapituloCadastroFormType;
use App\Form\CapituloFormType;
use App\Service\AutorLeitorService\AutorLeitorData;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class CapituloController extends AbstractController
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
     * @Route("/capitulo", name="capitulo", methods={"GET"})
     */
    public function index()
    {
        return $this->render('capitulo/index.html.twig', [
            'controller_name' => 'CapituloController',
        ]);
    }

    /**
     * @Route("/capitulo/{id}", name="capituloPorId", methods={"GET"}))
     */
    public function capituloHome(int $id)
    {
        $capitulo = $this->entityManager->getRepository(Capitulo::class)->find($id);

        $user = $this->security->getUser();
        if($user){
            $entityManager = $this->getDoctrine()->getManager();
            $leitor = $this->entityManager->getRepository(Historico::class)->findOneBy(["autor"=>$user]);
            if($leitor){
                $leitor->addCapitulo($capitulo);
                $entityManager->persist($leitor);
                $entityManager->flush();
            }else{
                $historico = new Historico();
                $historico->setAutor($user);
                $historico->addCapitulo($capitulo);
                $entityManager->persist($historico);
                $entityManager->flush();
            }

        }

        return $this->render('capitulo/index.html.twig', [
            'capitulo' => $capitulo,
        ]);
    }

    /**
     * @Route("/capitulos/create", name="cepituloCreate")
    */
    public function create(Request $request)
    {
        $user = $this->security->getUser();
        if(!$user){
            return $this->redirectToRoute('home');
        }

        $capitulo = new Capitulo();

        $form = $this->createForm(CapituloCadastroFormType::class,$capitulo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();

            $capitulo->setDataPublicacao( new DateTime("now"));
            $entityManager->persist($capitulo);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('capitulo/capitulo-form.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("create", name="create")
     */
    public function createPrimeiroCapitulo(Request $request)
    {
        $user = $this->security->getUser();
        if(!$user){
            return $this->redirectToRoute('home');
        }

        $capitulo = new Capitulo();

        $form = $this->createForm(CapituloCadastroFormType::class,$capitulo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();

            $capitulo->setDataPublicacao( new DateTime("now"));
            $entityManager->persist($capitulo);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('capitulo/capitulo-form.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/capitulos/create/{id}", name="cepituloCreatePorId")
     */
    public function createCapituloPorId(Request $request,int $id)
    {
        $user = $this->security->getUser();
        if(!$user){
            return $this->redirectToRoute('home');
        }

        $id_historia = $this->entityManager->getRepository(Historia::class)->find($id);

        $capitulo = new Capitulo();

        $form = $this->createForm(CapituloFormType::class,$capitulo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();

            $capitulo->setDataPublicacao( new DateTime("now"));
            $capitulo->setIdHistoria($id_historia);
            $entityManager->persist($capitulo);
            $entityManager->flush();

            return $this->redirectToRoute('myHistorias');
        }

        return $this->render('capitulo/capitulo-form.html.twig',[
            'form' => $form->createView()
        ]);
    }

}

<?php

namespace App\Controller;

use App\Entity\Capitulo;
use App\Entity\Comentario;
use App\Entity\Historia;
use App\Entity\Historico;
use App\Entity\LeitorAutor;
use App\Form\CapituloAtualizaFormType;
use App\Form\CapituloCadastroFormType;
use App\Form\CapituloFormType;
use App\Form\ComentarioFormType;
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
     * @Route("/capitulo/{id}", name="capituloPorId"))
     */
    public function capituloHome(int $id, Request $request)
    {
        $user = $this->security->getUser();

        $capitulo = $this->entityManager->getRepository(Capitulo::class)->find($id);

        $comentarios = $capitulo->getComentarios();

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

        $comentario = new Comentario();

        $form = $this->createForm(ComentarioFormType::class,$comentario);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $comentario->setDataPublicacao(new DateTime("now"));
            $comentario->setIdCapitulo($capitulo);
            $comentario->setIdLeitor($user);
            $entityManager->persist($comentario);
            $entityManager->flush();

            //return $this->redirectToRoute('capituloPorId');
        }

        return $this->render('capitulo/index.html.twig', [
            'capitulo' => $capitulo,
            'comentarios' => $comentarios,
            'form' => $form->createView()
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
            $capitulo->setIdAutor($user);
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
            $capitulo->setIdAutor($user);
            $entityManager->persist($capitulo);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('capitulo/capitulo-form.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/capitulos/create/{id}", name="capituloCreatePorId")
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
            $capitulo->setIdAutor($user);
            $entityManager->persist($capitulo);
            $entityManager->flush();

            return $this->redirectToRoute('myHistorias');
        }

        return $this->render('capitulo/capitulo-form.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/capitulos/rascunho/update/{id}", name="rascunhoCapituloUpdate")
     */
    public function updateRascunhoCapitulo(Request $request, int $id)
    {
        $user = $this->security->getUser();
        if(!$user){
            return $this->redirectToRoute('home');
        }

        $capitulo = $this->entityManager->getRepository(Capitulo::class)->find($id);

        if ($user == $capitulo->getIdAutor()){
            $form = $this->createForm(CapituloAtualizaFormType::class,$capitulo);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();
                return $this->redirectToRoute('rascunhoCapitulos');
            }

            return $this->render('historia/historia-atualiza.html.twig',[
                'form' => $form->createView()
            ]);
        }else{
            return $this->redirectToRoute('home');
        }

    }

    /**
     * @Route("/capitulos/update/{id}", name="capituloUpdate")
     */
    public function updateCapitulo(Request $request, int $id)
    {
        $user = $this->security->getUser();
        if(!$user){
            return $this->redirectToRoute('home');
        }

        $capitulo = $this->entityManager->getRepository(Capitulo::class)->find($id);

        if ($user == $capitulo->getIdAutor()){
            $form = $this->createForm(CapituloAtualizaFormType::class,$capitulo);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()){

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
     * @Route("/capitulos/delete/{id}", name="capituloDelete")
     */
    public function delete(int $id)
    {
        $user = $this->security->getUser();

        $capitulo = $this->entityManager->getRepository(Capitulo::class)->find($id);

        $historia = $this->entityManager->getRepository(Historia::class)->findOneBy(["id" => $capitulo->getIdHistoria()]);

        $autor = $historia->getIdAutor();

        $nome_autor = $autor->getApelido();

        $capitulos = $this->entityManager->getRepository(Capitulo::class)->findBy(["idHistoria" => $historia->getId()]);

        if ($user == $capitulo->getIdAutor()){

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($capitulo);
            $entityManager->flush();

            return $this->redirectToRoute('myHistorias');
        }else{
            return $this->redirectToRoute('home');
        }

    }

}

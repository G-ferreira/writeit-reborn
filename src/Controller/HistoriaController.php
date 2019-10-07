<?php

namespace App\Controller;

use App\Entity\Avaliacao;
use App\Entity\Capitulo;
use App\Entity\Comentario;
use App\Entity\Genero;
use App\Entity\Historia;
use App\Entity\LeitorAutor;
use App\Form\ComentarioFormType;
use App\Form\HistoriaAtualizaFormType;
use App\Form\HistoriaCadastroType;
use DateTime;
use Gedmo\Sluggable\Util\Urlizer;
use App\Service\AutorLeitorService\AutorLeitorData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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

            $generos = $form->get('genero')->getData();
            $categoria = $form->get('categoria')->getData();

            foreach ( $generos as $item) {
                $historia->addGenero($item);
            }

            foreach ( $categoria as $item) {
                $historia->addCategoria($item);
            }

            $historia->setIdAutor($user);

            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $form['image']->getData();

            $destination = $this->getParameter('kernel.project_dir').'/public/uploads/images/historias';
            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = Urlizer::urlize($originalFilename).'-'.uniqid().'.'.$uploadedFile->guessExtension();
            $uploadedFile->move(
                $destination,
                $newFilename
            );
            $historia->setImage($newFilename);

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
        $historias = $this->entityManager->getRepository(Historia::class)->findBy(["rascunho" => 1]);

        return $this->render('historia/historia-all.html.twig', [
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
        $user = $this->security->getUser();
        if(!$user){
            return $this->redirectToRoute('home');
        }

        $historia = $this->entityManager->getRepository(Historia::class)->find($id);

        $generos = $historia->getGeneros();

        $categorias = $historia->getCategorias();

        $autor = $historia->getIdAutor();

        $nome_autor = $autor->getApelido();

        $capitulos = $this->entityManager->getRepository(Capitulo::class)->findBy(["idHistoria" => $id, "status" => 1]);

        $avaliacao = $this->entityManager->getRepository(Avaliacao::class)->findOneBy(["idHistoria" => $historia->getId(), "idLeitor" => $user]);

        $avalicoes = $historia->getAvaliacaos();

        return $this->render('historia/index.html.twig', [
            'historia' => $historia,
            'capitulos' =>$capitulos,
            'nome_autor' => $nome_autor,
            'autor' => $autor,
            'generos' => $generos,
            'categorias' => $categorias,
            'avaliacoes' => $avalicoes,
            'avaliacao' => $avaliacao
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
     * @Route("/historia/rascunho/update/{id}", name="updateRascunhoHistoria")
     */
    public function updateRascunho(Request $request, int $id)
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

                return $this->redirectToRoute('rascunhoHistorias');
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

    /**
     * @Route("/historia/rascunho/delete/{id}", name="deleteRascunhoHistoria")
     */
    public function deleteRascunho(int $id)
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

            return $this->redirectToRoute('rascunhoHistorias');
        }else{
            return $this->redirectToRoute('home');
        }
    }

    /**
     * @Route("/like/{id}")
     */
    public function like(int $id)
    {
        $user = $this->security->getUser();

        $historia = $this->entityManager->getRepository(Historia::class)->find($id);

        $avaliacao = $this->entityManager->getRepository(Avaliacao::class)->findBy(["idHistoria" => $historia->getId(),"idLeitor" => $user->getId()]);

        if ($avaliacao == null){
            $votoLeitor = new Avaliacao();
            $entityManager = $this->getDoctrine()->getManager();
            $votoLeitor->setIdHistoria($historia);
            $votoLeitor->setIdLeitor($user);
            $votoLeitor->setVoto(1);
            $entityManager->persist($votoLeitor);
            $entityManager->flush();
        }

        return $this->redirectToRoute('historiaPorId',array('id'=>$id));

    }

    /**
     * @Route("/unlike/{id}")
     */
    public function unlike(int $id)
    {
        $user = $this->security->getUser();

        $historia = $this->entityManager->getRepository(Historia::class)->find($id);

        $avaliacao = $this->entityManager->getRepository(Avaliacao::class)->findOneBy(["idHistoria" => $historia->getId(), "idLeitor" => $user]);

        if ($avaliacao != null){
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($avaliacao);
            $entityManager->flush();
        }

        return $this->redirectToRoute('historiaPorId',array('id'=>$id));

    }
}

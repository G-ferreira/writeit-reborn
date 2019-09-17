<?php


namespace App\Controller;

use App\Entity\Capitulo;
use App\Entity\Historia;
use App\Service\AutorLeitorService\AutorLeitorData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;

class RascunhoController extends AbstractController
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

//    /**
//     * @Route("/rascunho/lista", name="rascunhoLista")
//     */
//    public function listaRascunho()
//    {
//        return $this->render('rascunho/rascunho-lista.html.twig', [
//
//        ]);
//    }

    /**
     * @Route("/rascunho/capitulos", name="rascunhoCapitulos")
     */
    public function listCapitulos()
    {
        $user = $this->security->getUser();
        if(!$user){
            return $this->redirectToRoute('home');
        }

        $capitulos = $this->entityManager->getRepository(Capitulo::class)->findBy(["idAutor" => $user->getId(),"status" => 0]);

        return $this->render('rascunho/rascunho-capitulos.html.twig', [
            'capitulos' => $capitulos
        ]);
    }

    /**
     * @Route("/rascunho/historias", name="rascunhoHistorias")
     */
    public function listHistoria()
    {
        $user = $this->security->getUser();
        if(!$user){
            return $this->redirectToRoute('home');
        }

        $historias = $this->entityManager->getRepository(Historia::class)->findBy(["idAutor" => $user->getId(),"rascunho" => 0]);

        return $this->render('rascunho/rascunho-lista.html.twig', [
            'historias' => $historias
        ]);
    }

}
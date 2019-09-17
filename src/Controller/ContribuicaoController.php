<?php

namespace App\Controller;

use App\Entity\Contribuicao;
use App\Entity\DadosPagamento;
use App\Entity\LeitorAutor;
use App\Form\ContribuicaoFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ContribuicaoController extends AbstractController
{

    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

//    /**
//     * @Route("/contribuicao", name="contribuicao")
//     */
//    public function index()
//    {
//        return $this->render('contribuicao/index.html.twig', [
//            'controller_name' => 'ContribuicaoController',
//        ]);
//    }

    /**
     * @Route("/contribuicao/lista", name="contribuicaoLista")
     */
    public function listaContribuição()
    {
        $user = $this->security->getUser();
        if(!$user){
            return $this->redirectToRoute('login');
        }

        $contribuicoes = $this->entityManager->getRepository(Contribuicao::class)->findBy(["idAutor" => $user->getId()]);

        return $this->render('contribuicao/contribuicao-lista.html.twig', [
            'lista' => $contribuicoes
        ]);
    }

    /**
     * @Route("/contribuir/{id}", name="contribuir")
     */
    public function fazerContribuicao(Request $request, int $id)
    {
        $user = $this->security->getUser();
        if(!$user){
            return $this->redirectToRoute('login');
        }

        $autor = $this->entityManager->getRepository(LeitorAutor::class)->find($id);

        $contribuicao = new Contribuicao();

        $form = $this->createForm(ContribuicaoFormType::class,$contribuicao);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $contribuicao->setIdAutor($autor->getId());
            $contribuicao->setIdPagador($user->getId());
            $contribuicao->setNomePagador($user->getApelido());
            $entityManager->persist($contribuicao);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('contribuicao/index.html.twig',[
            'form' => $form->createView(),
            'autor' => $autor
        ]);
    }
}

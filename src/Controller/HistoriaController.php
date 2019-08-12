<?php

namespace App\Controller;

use App\Entity\Historia;
use App\Entity\LeitorAutor;
use App\Form\HistoriaCadastroType;
use App\Service\AutorLeitorService\AutorLeitorData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class HistoriaController extends AbstractController
{

    private $autorLeitorData;
    private $security;

    public function __construct(AutorLeitorData $autorLeitorData, Security $security)
    {
        $this->autorLeitorData = $autorLeitorData;
        $this->security = $security;
    }


    /**
     * @Route("/historia", name="historias")
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
            return $this->redirectToRoute('index');
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
}

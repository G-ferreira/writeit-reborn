<?php

namespace App\Controller;

use App\Entity\Historia;
use App\Form\HistoriaCadastroType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;


class HistoriaController extends AbstractController
{

    private $security;

    public function __construct(Security $security)
    {
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

        return $this->render('historia/historia.html.twig',[
           'form' => $form->createView()
        ]);
    }
}

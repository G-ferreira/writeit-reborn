<?php

namespace App\Controller;

use App\Entity\Historia;
use App\Form\HistoriaCadastroType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HistoriaController extends AbstractController
{
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
     * @Route("/historia/create", name="historia")
     */
    public function create(Request $request)
    {
        $historia = new Historia();

        $form = $this->createForm(HistoriaCadastroType::class,$historia);

        return $this->render('historia/historia.html.twig',[
           'form' => $form->createView()
        ]);
    }
}

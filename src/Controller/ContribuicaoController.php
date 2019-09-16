<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContribuicaoController extends AbstractController
{
    /**
     * @Route("/contribuicao", name="contribuicao")
     */
    public function index()
    {
        return $this->render('contribuicao/index.html.twig', [
            'controller_name' => 'ContribuicaoController',
        ]);
    }

    /**
     * @Route("/contribuicao/lista", name="contribuicaoLista")
     */
    public function listaContribuição()
    {
        return $this->render('contribuicao/contribuicao-lista.html.twig', [

        ]);
    }
}

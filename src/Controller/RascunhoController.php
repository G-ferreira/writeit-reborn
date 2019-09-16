<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RascunhoController extends AbstractController
{

    /**
     * @Route("/rascunho/lista", name="rascunhoLista")
     */
    public function listaRascunho()
    {
        return $this->render('rascunho/rascunho-lista.html.twig', [

        ]);
    }

}
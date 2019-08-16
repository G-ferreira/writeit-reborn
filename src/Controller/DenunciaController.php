<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DenunciaController extends AbstractController
{
    /**
     * @Route("/denuncia", name="denuncia")
     */
    public function index()
    {
        return $this->render('denuncia/index.html.twig', [
            'controller_name' => 'DenunciaController',
        ]);
    }
}

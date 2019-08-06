<?php


namespace App\Controller;


use App\Entity\AutorLeitor;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class LivroController
{
    /**
     * @Route("/")
     */
    public function number()
    {
        return new JsonResponse(["tamoFudido"=>"vrummmmm"]);
    }
}

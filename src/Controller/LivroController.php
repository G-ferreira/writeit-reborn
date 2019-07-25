<?php


namespace App\Controller;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class LivroController
{
    /**
     * @Route("/")
     */
    public function number()
    {
        return new JsonResponse(["kkkkkk"=>"kkkkkk"]);
    }
}
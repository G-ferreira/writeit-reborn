<?php

namespace App\Controller;

use App\Service\AutorLeitorService\AutorLeitorData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    private $autorLeitorData;

    public function __construct(AutorLeitorData $autorLeitorData)
    {
        $this->autorLeitorData = $autorLeitorData;
    }

    /**
     * @Route("/index", name="index")
     */
    public function index()
    {
//        $data = $this->format($this->autorLeitorData->listAll());
        return $this->render('index/index.html.twig', [
            'variavel' => 'oiiiiiiiiiiiiiiii',
            'users' => []
        ]);
    }

    private function format($body)
    {
        $list = [];
        foreach ($body as $item){
            $list[] = [
                "nome" => $item->getNome(),
                "email" => $item->getEmail()
            ];
        }
        return $list;
    }
}

<?php

namespace App\Controller;

use App\Service\AutorLeitorService\AutorLeitorData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\LeitorAutorLoginFormType;
use Symfony\Component\Security\Core\Security;

class IndexController extends AbstractController
{
    private $autorLeitorData;
    private $security;

    public function __construct(AutorLeitorData $autorLeitorData, Security $security)
    {
        $this->autorLeitorData = $autorLeitorData;
        $this->security = $security;
    }

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $user = $this->security->getUser();
        if($user){
            return $this->render('index/index.html.twig', [
                'variavel' => $user
            ]);
        }
//      $data = $this->format($this->autorLeitorData->listAll());

        return $this->render('index/index.html.twig', [
            'variavel' => []
        ]);
    }


}

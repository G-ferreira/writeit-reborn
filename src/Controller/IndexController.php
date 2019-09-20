<?php

namespace App\Controller;

use App\Entity\Historia;
use App\Entity\LeitorAutor;
use App\Service\AutorLeitorService\AutorLeitorData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\LeitorAutorLoginFormType;
use Symfony\Component\Security\Core\Security;

class IndexController extends AbstractController
{
    private $autorLeitorData;
    private $security;

    public function __construct(AutorLeitorData $autorLeitorData, Security $security,EntityManagerInterface $entityManager)
    {
        $this->autorLeitorData = $autorLeitorData;
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $autores = $this->entityManager->getRepository(LeitorAutor::class)->findAll();

        $historias = $this->entityManager->getRepository(Historia::class)->findBy(["rascunho" => 1]);

        $user = $this->security->getUser();
        if($user){
            return $this->render('index/index.html.twig', [
                'variavel' => $user,
                'autores' => $autores,
                'historias' => $historias
            ]);
        }
//      $data = $this->format($this->autorLeitorData->listAll());

        return $this->render('index/index.html.twig', [
            'variavel' => [],
            'autores' => $autores,
            'historias' => $historias
        ]);
    }


}

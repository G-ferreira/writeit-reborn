<?php


namespace App\Controller;

use App\Entity\Historico;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HistoricoController extends AbstractController
{
    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }


    /**
     * @Route("/historico", name="historico")
     */
    public function index()
    {
        $user = $this->security->getUser();
        if(!$user){
            return $this->redirectToRoute('home');
        }

        $historico = $this->entityManager->getRepository(Historico::class)->findOneBy(["autor"=>$user]);


        return $this->render('historico/index.html.twig', [
            'historico' => $historico,
        ]);
    }
}
<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Entity\Denuncia;
use App\Entity\Genero;
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
    private $entityManager;

    public function __construct(AutorLeitorData $autorLeitorData, Security $security, EntityManagerInterface $entityManager)
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

        $autoresRecomendados = $this->entityManager->createQueryBuilder()
            ->select('a')
            ->from('App\Entity\LeitorAutor', 'a')
            ->setMaxResults(5)
            ->getQuery()->getResult();

        $categorias = $this->entityManager->getRepository(Categoria::class)->findAll();

        $genero1 = $this->entityManager->getRepository(Genero::class)->find(1);
        $nameGenero1 = $genero1->getTitulo();
        $historias1 = $genero1->getHistorias();



        $genero2 = $this->entityManager->getRepository(Genero::class)->find(2);
        $nameGenero2 = $genero2->getTitulo();
        $historias2 = $genero2->getHistorias();

        $user = $this->security->getUser();
        if ($user) {
            return $this->render('index/index.html.twig', [
                'variavel' => $user,
                'autores' => $autoresRecomendados,
                'nameGenero1' => $nameGenero1,
                'genero1' => $historias1,
                'nameGenero2' => $nameGenero2,
                'genero2' => $historias2,
                'historias' => $historias,
                'categorias' => $categorias
            ]);
        }
//      $data = $this->format($this->autorLeitorData->listAll());

        return $this->render('index/index.html.twig', [
            'variavel' => [],
            'autores' => $autoresRecomendados,
            'nameGenero1' => $nameGenero1,
            'genero1' => $historias1,
            'nameGenero2' => $nameGenero2,
            'genero2' => $historias2,
            'historias' => $historias,
            'categorias' => $categorias
        ]);
    }

}

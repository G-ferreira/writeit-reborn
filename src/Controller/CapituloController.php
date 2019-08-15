<?php

namespace App\Controller;

use App\Entity\Capitulo;
use App\Form\CapituloCadastroFormType;
use App\Service\AutorLeitorService\AutorLeitorData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class CapituloController extends AbstractController
{

    private $entityManager;
    private $autorLeitorData;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, AutorLeitorData $autorLeitorData, Security $security)
    {
        $this->autorLeitorData = $autorLeitorData;
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/capitulo", name="capitulo")
     */
    public function index()
    {
        return $this->render('capitulo/index.html.twig', [
            'controller_name' => 'CapituloController',
        ]);
    }

    /**
     * @Route("/capitulo/{id}", name="capituloPorId")
     */
    public function capituloHome(int $id)
    {
        $capitulo = $this->entityManager->getRepository(Capitulo::class)->find($id);

        return $this->render('capitulo/index.html.twig', [
            'capitulo' => $capitulo,
        ]);
    }

    /**
     * @Route("/capitulo/create/{id}", name="capituloPorId")

    public function create(Request $request,int $id)
    {
        $user = $this->security->getUser();
        if(!$user){
            return $this->redirectToRoute('home');
        }

        $capitulo = new Capitulo();

        $form = $this->createForm(CapituloCadastroFormType::class,$capitulo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $capitulo->setIdHistoria($id);

            $entityManager->persist($capitulo);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('capitulo/capitulo-form.html.twig',[
            'form' => $form->createView()
        ]);
    }
     * */
}

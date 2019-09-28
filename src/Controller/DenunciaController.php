<?php

namespace App\Controller;

use App\Entity\Denuncia;
use App\Entity\Historia;
use App\Entity\LeitorAutor;
use App\Form\DenunciaFormType;
use Doctrine\ORM\EntityManagerInterface;;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;

class DenunciaController extends AbstractController
{
    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/denuncia", name="denuncia")
     */
    public function index()
    {
        return $this->render('denuncia/index.html.twig', [

        ]);
    }

    /**
     * @Route("/denuncia/sucesso", name="denunciaSucesso")
     */
    public function denunciaSucesso()
    {
        return $this->render('denuncia/denuncia-sucesso.html.twig', [

        ]);
    }


    /**
     * @Route("/denuncia/create/{id}", name="denunciaCreate")
     */
    public function create(Request $request, int $id)
    {
        $user = $this->security->getUser();
        if(!$user){
            return $this->redirectToRoute('home');
        }

        $denuncia = new Denuncia();

        $form = $this->createForm(DenunciaFormType::class,$denuncia);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();

            $denuncia->setUser($user->getUsername());
            $denuncia->setIdHistoria($id);
            $denuncia->setStatus(0);

            $entityManager->persist($denuncia);
            $entityManager->flush();

            return $this->redirectToRoute('denunciaSucesso');
        }

        return $this->render('denuncia/denuncia-form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/denuncia/list", methods={"GET"}, name="denuncias")
     */
    public function list()
    {
        $denunciaList = $this->entityManager->getRepository(Denuncia::class)->findBy(["status" => 0]);

        return $this->render('denuncia/lista-denuncia.html.twig',[
           'lista' => $denunciaList
        ]);
    }

    /**
     * @Route("/denuncia/list/aprovadas", methods={"GET"})
     */
    public function listaAprovadas()
    {
        $denunciaList = $this->entityManager->getRepository(Denuncia::class)->findBy(["status" => 1]);

        return $this->render('denuncia/lista-denuncia-aprovadas.html.twig',[
            'lista' => $denunciaList
        ]);
    }

    /**
     * @Route("/denuncia/{id}")
     */
    public function aprovarDenuncia(int $id)
    {
        $denuncia = $this->entityManager->getRepository(Denuncia::class)->find($id);

        $entityManager = $this->getDoctrine()->getManager();

        $denuncia->setStatus(1);

        $entityManager->persist($denuncia);
        $entityManager->flush();

        return $this->redirectToRoute('denuncias');
    }

}

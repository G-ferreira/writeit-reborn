<?php


namespace App\Controller;


use App\Entity\LeitorAutor;
use App\Form\LeitorAutorLoginFormType;
use App\Service\AutorLeitorService\AutorLeitorData;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AutorLeitorController extends AbstractController
{

    public function __construct()
    {

    }

    /**
     * @Route("/user/create", name="criaUsuario")
     */
    public function create(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

        $user = new LeitorAutor();

        $form = $this->createForm(LeitorAutorLoginFormType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $user->setPassword($passwordEncoder->encodePassword($user,$form->get('password')->getData()));
            $user->setEmail($form->get('email')->getData());

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('autorLeitor/autorLeitor.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('autorLeitor/login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }
}

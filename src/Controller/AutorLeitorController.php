<?php


namespace App\Controller;


use App\Entity\DadosPagamento;
use App\Entity\Historia;
use App\Entity\LeitorAutor;
use App\Form\DadosPagamentoCadastroFormType;
use App\Form\LeitorAutorLoginFormType;
use App\Service\AutorLeitorService\AutorLeitorData;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AutorLeitorController extends AbstractController
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

            return $this->redirectToRoute('home');
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

    /**
     * @Route("/perfil", name="perfil")
     */
    public function perfil()
    {
        $user = $this->security->getUser();
        if(!$user){
            return $this->redirectToRoute('home');
        }

        $historias = $this->entityManager->getRepository(Historia::class)->findBy(["idAutor" => $user->getId()]);

        return $this->render('autorLeitor/perfil.html.twig', [
            'historias' => $historias
        ]);

    }

    /**
     * @Route("/autores", name="autores")
     */
    public function buscarTodos(): Response
    {
        $categoriaList = $this->entityManager->getRepository(LeitorAutor::class)->findAll();
        return $this->render('autorLeitor/lista-autores.html.twig', [
            'lista' => $categoriaList,
        ]);
    }

    /**
     * @Route("/autores/{id}", methods={"GET"})
     */
    public function buscarPorId(int $id): Response
    {
        $historias = $this->entityManager->getRepository(Historia::class)->findBy(["idAutor" => $id]);

        return $this->render('autorLeitor/perfil.html.twig', [
            'historias' => $historias
        ]);
    }

    /**
     * @Route("/configuracao", name="configuracao")
     */
    public function configuracao()
    {
        $user = $this->security->getUser();
        if(!$user){
            return $this->redirectToRoute('home');
        }

        $dados = $this->entityManager->getRepository(DadosPagamento::class)->findOneBy(["idAutorLeitor" => $user->getId()]);

        return $this->render('autorLeitor/configuracao-autor.html.twig', [
            'dados' => $dados
        ]);
    }

    /**
     * @Route("/dados/create", name="dadosPagamentoCreate")
     */
    public function createDadosPagamento(Request $request)
    {
        $user = $this->security->getUser();
        if(!$user){
            return $this->redirectToRoute('home');
        }

        $dadosPagamento = new DadosPagamento();

        $form = $this->createForm(DadosPagamentoCadastroFormType::class,$dadosPagamento);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $dadosPagamento->setValor(0);
            $dadosPagamento->setIdAutorLeitor($user);

            $entityManager->persist($dadosPagamento);
            $entityManager->flush();

            return $this->redirectToRoute('home');
        }

        return $this->render('autorLeitor/dados-pagamento-form.html.twig',[
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/dados/update", name="dadosPagamentoAtualiza")
     */
    public function updateDadosPagamento(Request $request)
    {
        $user = $this->security->getUser();
        if(!$user){
            return $this->redirectToRoute('home');
        }

        $dados = $this->entityManager->getRepository(DadosPagamento::class)->findOneBy(["idAutorLeitor" => $user->getId()]);

        $form = $this->createForm(DadosPagamentoCadastroFormType::class,$dados);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->flush();

            return $this->redirectToRoute('configuracao');
        }

        return $this->render('autorLeitor/dados-pagamento-form.html.twig',[
            'form' => $form->createView()
        ]);
    }

}

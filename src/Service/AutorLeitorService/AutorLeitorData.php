<?php


namespace App\Service\AutorLeitorService;

use App\Entity\AutorLeitor;
use Doctrine\ORM\EntityManagerInterface;

class AutorLeitorData
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save($nome, $email, $senha)
    {
        $autorLeitor = new AutorLeitor();

        $autorLeitor->setNome($nome);
        $autorLeitor->setEmail($email);
        $autorLeitor->setSenha($senha);

        $this->entityManager->persist($autorLeitor);
        $this->entityManager->flush();
    }

    public function listAll()
    {
        $users = $this->entityManager->getRepository(AutorLeitor::class)->findAll();
        return $users;
    }
}
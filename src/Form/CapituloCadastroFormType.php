<?php

namespace App\Form;

use App\Entity\Capitulo;
use App\Entity\Historia;
use Doctrine\ORM\EntityManagerInterface;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use ReflectionClass;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class CapituloCadastroFormType extends AbstractType
{
    private $entityManager;
    private $security;

    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->security->getUser();
        $historias = $this->entityManager->getRepository(Historia::class)->findBy(["idAutor" => $user->getId()]);
        $builder
            ->add('titulo')
            ->add('texto', CKEditorType::class, array(
                'config' => array(
                    'uiColor' => '#ffffff'
                )))
            ->add('idHistoria',ChoiceType::class,[
                'label' => "Historia",
                'choices' => $historias,
                'choice_label' => function(Historia $category, $key, $value) {
                    return strtoupper($category->getTitulo());
                }])
            ->add('save',SubmitType::class,['label' => 'Concluir'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Capitulo::class,
        ]);
    }
}

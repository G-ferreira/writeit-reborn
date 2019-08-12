<?php

namespace App\Form;

use App\Entity\Categoria;
use App\Entity\Genero;
use App\Entity\Historia;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Form\FormInterface;

class HistoriaCadastroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo')
            ->add('sinopse')
            ->add('status',null ,array(
                'label' => 'Historia ativa?'
            ))
            ->add('classificacao')
            ->add('categoria', EntityType::class, [
                'multiple' => true,
                'expanded' => true,
                'class'    => Categoria::class
            ])
            ->add('genero', EntityType::class, [
                'multiple' => true,
                'expanded' => true,
                'class'    => Genero::class
            ])
            ->add('save',SubmitType::class,['label' => 'Concluir'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Historia::class,
        ]);
    }
}

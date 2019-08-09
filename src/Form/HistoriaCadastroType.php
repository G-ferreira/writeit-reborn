<?php

namespace App\Form;

use App\Entity\Historia;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HistoriaCadastroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo')
            ->add('sinopse')
            ->add('status')
            ->add('classificacao')
            //->add('idCategoria')
            //->add('idGenero')
            //->add('idAutor')
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

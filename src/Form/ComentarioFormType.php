<?php

namespace App\Form;

use App\Entity\Comentario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ComentarioFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('texto',null,array(
                'label' => 'Adicionar comentário'
            ))
            //->add('dataPublicacao')
            //->add('idCapitulo')
            ->add('save',SubmitType::class,['label' => 'Enviar'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comentario::class,
        ]);
    }
}

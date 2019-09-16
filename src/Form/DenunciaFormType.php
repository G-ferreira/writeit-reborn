<?php

namespace App\Form;

use App\Entity\Denuncia;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DenunciaFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('texto',null,array(
                'label' => 'Explique o motivo da denúncia'
            ))
            ->add('save',SubmitType::class,['label' => 'Enviar'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Denuncia::class,
        ]);
    }
}

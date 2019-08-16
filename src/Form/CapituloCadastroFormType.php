<?php

namespace App\Form;

use App\Entity\Capitulo;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use ReflectionClass;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CapituloCadastroFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo')
            ->add('texto', CKEditorType::class, array(
                'config' => array(
                    'uiColor' => '#ffffff'
                )))
            ->add('dataPublicacao')
            ->add('idHistoria')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Capitulo::class,
        ]);
    }
}

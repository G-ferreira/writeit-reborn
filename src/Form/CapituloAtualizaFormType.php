<?php

namespace App\Form;

use App\Entity\Capitulo;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CapituloAtualizaFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo')
            ->add('texto', CKEditorType::class, array(
                'config' => array(
                    'uiColor' => '#ffffff'
                )))
            //->add('dataPublicacao')
            ->add('status', ChoiceType::class,array(
                'choices' => array(
                    'Publicar' => '1',
                    'Rascunho' => '0'
                )))
            //->add('idHistoria')
            //->add('historicos')
            //->add('idAutor')
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

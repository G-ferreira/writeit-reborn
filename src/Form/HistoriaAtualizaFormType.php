<?php

namespace App\Form;

use App\Entity\Historia;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HistoriaAtualizaFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titulo')
            ->add('sinopse')
            ->add('status',ChoiceType::class,array(
                'choices' => array(
                    'Concluída' => '1',
                    'Em andamento' => 0
                )
            ))
            //->add('classificacao')
            //->add('data_publicacao')
            //->add('categoria')
            //->add('genero')
            //->add('idAutor')
            ->add('rascunho', ChoiceType::class,array(
                'choices' => array(
                    'Publicar' => '1',
                    'Rascunho' => '0'
                )
            ))
            ->add('save',SubmitType::class,['label' => 'Salvar'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Historia::class,
        ]);
    }
}

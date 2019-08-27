<?php

namespace App\Form;

use App\Entity\DadosPagamento;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DadosPagamentoCadastroFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('valor')
            ->add('numeroConta')
            ->add('agencia')
            ->add('banco')
            ->add('cpf')
            //->add('idAutorLeitor')
            ->add('save',SubmitType::class,['label' => 'Concluir'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DadosPagamento::class,
        ]);
    }
}

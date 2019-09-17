<?php

namespace App\Form;

use App\Entity\Contribuicao;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContribuicaoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            //->add('idPagador')
            ->add('valor',null,array(
                'label' => 'Digite a quantidade em R$',
            ))
            ->add('numeroCartao',null,array(
                'attr' => array(
                    'label' => 'Número do Cartão'
                )
            ))
            ->add('dataVencimento',null,array(
                'attr' => array(
                    'label' => 'Data Vencimento'
                )
            ))
            ->add('cvv',null,array(
                'label' => 'cvv'
            ))
            ->add('nomeTitular')
            ->add('cpf',null,array(
                'label' => 'CPF'
            ))
            ->add('save',SubmitType::class,['label' => 'Confirmar'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contribuicao::class,
        ]);
    }
}

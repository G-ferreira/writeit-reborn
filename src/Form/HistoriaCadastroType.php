<?php

namespace App\Form;

use App\Entity\Categoria;
use App\Entity\Genero;
use App\Entity\Historia;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Button;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
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
            ->add('image', FileType::class, [
                'mapped' => false,
                'label' => false,
                'attr' => ['placeholder' => 'Choose file']
            ])
            ->add('sinopse')
            ->add('status',ChoiceType::class,array(
                'choices' => array(
                    'Concluída' => '1',
                    'Em andamento' => 0
                )
            ))
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
            ->add('classificacao',ChoiceType::class,array(
                'choices' => array(
                    'Conteúdo livre' => 'Livre',
                    'Conteúdo violento ou linguagem inapropriada' => '10',
                    'Agressão física, consumo de drogas e insinuação sexual' => '12',
                    'Conteúdo mais violento e/ou de linguagem sexual' => '14',
                    'Tortura, suicídio ou estupro' => '16',
                    'Sexo, tortura ou abuso sexual' => '18'
                ),
                'label' => 'Tipo de conteúdo'
            ))
            ->add('rascunho', ChoiceType::class,array(
                'choices' => array(
                    'Publicar' => '1',
                    'Rascunho' => '0'
                )
            ))
            ->add('save',SubmitType::class,['label' => 'Cadastrar Capitulo'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Historia::class,
        ]);
    }

    public function prePersist($image)
    {
        $this->manageFileUpload($image);
    }

    public function preUpdate($image)
    {
        $this->manageFileUpload($image);
    }

    private function manageFileUpload($image)
    {
        if ($image->getFile()) {
            $image->refreshUpdated();
        }
    }
}

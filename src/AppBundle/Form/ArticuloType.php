<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ArticuloType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('titulo', TextType::class)
        ->add('descripcionCorta', TextType::class)
        ->add('descripcionLarga', TextareaType::class)
        ->add('imagen', FileType::class,array('attr'=>array('onChange'=>'onChange(event)')))
        ->add('guardar', SubmitType::class, ['label' => 'Crear'])
        ;
    }
}

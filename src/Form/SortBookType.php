<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
Use App\Entity\Category;

class SortBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('category', EntityType::class, [
          "class" => Category::class,
          "choice_label" => "title",
          'attr' => ['class' => 'form-control']
        ])
        ->add("Rechercher", SubmitType::class, [
          'attr' => ['class' => 'btn sec-bg mx-2']
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'attr' => ['class' => 'form-inline my-3']
        ]);
    }
}

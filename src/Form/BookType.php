<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
Use App\Entity\Category;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
              'attr' => ['class' => 'form-control']
            ])
            ->add('author', TextType::class, [
              'attr' => ['class' => 'form-control']
            ])
            ->add('summary', TextAreaType::class, [
              'attr' => ['class' => 'form-control']
            ])
            ->add('publication', DateType::class, [
              "widget" => "single_text",
              'attr' => ['class' => 'form-control']
            ])
            ->add('availability', CheckBoxType::class, [
              'label_attr' => ['class' => 'form-check-label'],
              'attr' => ['class' => 'form-check-input mx-3']
            ])
            ->add('category', EntityType::class, [
              "class" => Category::class,
              "choice_label" => "title",
              'attr' => ['class' => 'form-control']
            ])
            ->add("Enregistrer", SubmitType::class, [
              'attr' => ['class' => 'btn btn-success']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
            'attr' => ['class' => 'w-50 mx-auto']
        ]);
    }
}

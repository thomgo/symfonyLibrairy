<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
Use App\Entity\Category;
Use App\Entity\Librairy;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, ['label' => "Titre"])
            ->add('author', null, ['label' => "Auteur"])
            ->add('summary', null, ['label' => "Résumé"])
            ->add('publication', null, [
              'label' => "Date de publication",
              "widget" => "single_text",
            ])
            ->add('availability', null, ['label' => 'Disponible'])
            ->add('category', EntityType::class, [
              "class" => Category::class,
              "choice_label" => "title",
              "label" => "Catégorie"
            ])
            ->add('librairy', EntityType::class, [
              "class" => Librairy::class,
              "choice_label" => "name",
              "label" => "Bibliothèque"
            ])
            ->add("Enregistrer", SubmitType::class, [
              'attr' => ['class' => 'btn sec-bg']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}

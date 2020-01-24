<?php

namespace App\Form;

use App\Entity\Categories;
use App\Entity\News;
use App\Form\ImagesType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
      ->add('title', TextType::class)
      ->add('categorie', EntityType::class, ['class' => Categories::class, 'choice_label' => 'name'])
      ->add('content', TextareaType::class)
      ->add('picture', ImagesType::class);
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      'data_class' => News::class,
    ]);
  }
}

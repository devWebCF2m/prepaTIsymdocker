<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Section;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('titleSlug')
            ->add('text')
            ->add('articleDateCreate', null, [
                'widget' => 'single_text',
            ])
            ->add('articleDatePosted', null, [
                'widget' => 'single_text',
            ])
            ->add('published')
            ->add('User', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'username',
            ])
            ->add('sections', EntityType::class, [
                'class' => Section::class,
                'choice_label' => 'id',
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}

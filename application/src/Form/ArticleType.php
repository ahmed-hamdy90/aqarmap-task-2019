<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Form\Abstracts\AbstractForm;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * ArticleType Class represent custom form of @see Article will use in add/edit operation under aqarmap task application
 * @package App\Form
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
class ArticleType extends AbstractForm
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Title', 'required' => true])
            ->add('content', TextareaType::class, ['label' => 'Details', 'required' => true])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'label' => 'Categories which article belong to',
                'choices' => $options['categoriesOptions'],
                'choice_name' =>  'name',
                'choice_label' => 'name',
                'choice_value' => 'id',
                'multiple' => true,
                'expanded' => true,
                'required' => true
            ])
            ->add('save', SubmitType::class, ['label' => 'Add Article']);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'categoriesOptions' => [] // default value for category multi-choose field
        ]);
    }
}

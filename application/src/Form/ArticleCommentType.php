<?php

namespace App\Form;

use App\Entity\Comment;
use App\Form\Abstracts\AbstractForm;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * ArticleCommentType Class represent custom form of @see Comment under @see Article will use in add operation under aqarmap task application
 * @package App\Form
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
class ArticleCommentType extends AbstractForm
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, ['label' => 'Comment', 'required' => true])
            ->add('save', SubmitType::class, ['label' => 'Add Comment']);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class
        ]);
    }
}
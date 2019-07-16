<?php

namespace App\Form;

use App\Entity\User;
use App\Form\Abstracts\AbstractForm;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * LoginType Class represent custom form of login operation under aqarmap task application
 * @package App\Form
 * @author Ahmed Hamdy <ahmedhamdy20@gmail.com>
 */
class LoginType extends AbstractForm
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', EmailType::class, ['label' => 'Email', 'required' => true])
            ->add('password', PasswordType::class, ['label' => 'Password', 'required' => true])
            ->add('save', SubmitType::class, ['label' => 'Login']);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
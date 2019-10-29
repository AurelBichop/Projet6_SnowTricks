<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordType extends AppType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('newPassword',PasswordType::class,$this->getConfiguration('Mot de passe','Donner le nouveau mot de passe'))
            ->add('confirmPassword', PasswordType::class,$this->getConfiguration('Confirmation du mot de passe','retapez  votre mot de pass'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

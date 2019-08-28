<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AppType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName',TextType::class,$this->getConfiguration('Nom','Donner votre nom'))
            ->add('lastName',TextType::class,$this->getConfiguration('Votre Prenom','Donner votre prenom'))
            ->add('email',EmailType::class,$this->getConfiguration('Email','Votre adresse email'))
            ->add('password',PasswordType::class,$this->getConfiguration('Mot de passe','choisissez un mot de passe'))
            ->add('passwordConfirm',PasswordType::class,$this->getConfiguration('Confirmation du mot de passe','Confirmez votre mot de passe'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

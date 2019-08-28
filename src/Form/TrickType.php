<?php

namespace App\Form;

use App\Entity\Trick;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickType extends AppType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class,$this->getConfiguration('Titre','Donner le nom de votre trick'))
            ->add('description',TextareaType::class,$this->getConfiguration('Description','Donner une description a votre trick'))
            ->add('variety',ChoiceType::class,[
                'choices'=>[
                    'group1'=> 1,
                    'group2'=> 2,
                    'group3'=>3
                ]

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}

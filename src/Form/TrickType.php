<?php

namespace App\Form;

use App\Entity\Trick;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrickType extends AbstractType
{

    /** Permet de configurer un champ
     *
     * @param $label
     * @param $placeholder
     * @return array
     */
    private function getConfiguration($label,$placeholder){

        return [

            'label' => $label,
            'attr'  => [
                'placeholder'=>$placeholder
             ]
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class,$this->getConfiguration('Titre','Donner le nom de votre trick'))
            ->add('description',TextareaType::class,$this->getConfiguration('Description','Donner une description a votre trick'))
            ->add('variety',TextType::class,$this->getConfiguration('Groupe','Choisissez le groupe de votre trick'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}

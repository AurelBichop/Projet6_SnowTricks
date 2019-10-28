<?php

namespace App\Form;

use App\Entity\Trick;


use App\Entity\Variety;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class TrickType extends AppType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('titre',TextType::class,$this->getConfiguration('Titre','Donner le nom de votre trick'))
            ->add('description',TextareaType::class,$this->getConfiguration('Description','Donner une description a votre trick'))
            ->add('variety',EntityType::class,[
                'class'=>Variety::class,
                'choice_label'=>'title',
                'label'=>'Catégorie'
            ])
            ->add('coverImage',FileType::class,[
                'label'=>'Image de fond',
                'mapped' => false,
                'required' => false,
                 'constraints' => [
                        new File([
                            'maxSize' => '3000k',
                            'mimeTypes' => [
                                'image/jpeg'
                            ],
                            'mimeTypesMessage' => 'Please upload a valid JPG document',
                        ])
                    ],
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Image;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('url',FileType::class,[
                    'label'=>'Choix de l\'image',
                    'mapped' => false,
                    'required' => true,
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
            'data_class' => Image::class,
        ]);
    }
}

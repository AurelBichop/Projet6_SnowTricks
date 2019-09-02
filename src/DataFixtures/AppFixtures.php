<?php

namespace App\DataFixtures;

use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {

        $faker = Factory::create('fr-FR');

        // Création de l'utisateur pour le dev
        $userDev = new User();
        $password = $this->encoder->encodePassword($userDev,'password');

        $userDev->setEmail('linux.aurelien@gmail.com')
             ->setFirstName('Aurelien')
             ->setLastName('Bichotte')
             ->setValid(1)
             ->setPassword($password);

        $manager->persist($userDev);

        //création de faux utilisateur
        $users=[];

        for ($i =1;$i<=30;$i++){

            $user = new User();

            $password = $this->encoder->encodePassword($user,'password');

            $user->setEmail($faker->email)
                ->setFirstName($faker->firstName)
                ->setLastName($faker->lastName)
                ->setPassword($password);

            $manager->persist($user);

            $users[] = $user;
        }


        //Création de faux tricks
        for ($i =1;$i<=30;$i++){

            $user = $users[mt_rand(0,count($users)-1)];

            $title = $faker->sentence(mt_rand(1,4));
            $description = $faker->paragraph(mt_rand(0,10));
            $variety = 'groupe'.mt_rand(1,5);
            $coverImage = $faker->imageUrl();

            $trick = new Trick();

            $trick->setTitre($title)
                  ->setDescription($description)
                  ->setVariety($variety)
                  ->setCreatedAt($faker->dateTime())
                  ->setCoverImage($coverImage)
                  ->setAuthor($user);


            for($j = 1; $j <= mt_rand(1,8); $j++) {
                $image = new Image();
                $image->setUrl($faker->imageUrl())
                    ->setTitle($faker->sentence())
                    ->setTrick($trick);

                $manager->persist($image);
            }

            $manager->persist($trick);
        }

        // $product = new Product();
        // $manager->persist($product);



        $manager->flush();
    }
}

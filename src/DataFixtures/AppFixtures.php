<?php
namespace App\DataFixtures;

use App\Entity\Trick;
use App\Entity\User;
use App\Entity\Variety;
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

        //Creation des variety
        $variety1 = new Variety();
        $variety1->setTitle('categorie1');

        $variety2 = new Variety();
        $variety2->setTitle('categorie1');

        $varietys = [$variety1,$variety2];


        // Création de l'utisateur pour le dev
        $userDev = new User();
        $password = $this->encoder->encodePassword($userDev,'password');
        $userDev->setEmail('linux.aurelien@gmail.com')
            ->setFirstName('Aurelien')
            ->setLastName('Bichotte')
            ->setCreatedAt($faker->dateTimeBetween('-6 months'))
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
            $trick = new Trick();
            $trick->setTitre($title)
                ->setDescription($description)
                ->setVariety($varietys[mt_rand(0,1)])
                ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                ->setAuthor($user);
            $manager->persist($trick);
        }
        // $product = new Product();
        // $manager->persist($product);
        $manager->flush();
    }
}
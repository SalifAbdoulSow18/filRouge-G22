<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Profil;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $profils =["ADMIN","FORMATEUR" ,"APPRENANT" ,"CM"];
        foreach ($profils as $key => $libelle) {
            $profil =new Profil() ;
            $profil ->setLibelle ($libelle );
            $manager ->persist($profil);
            $manager ->flush();
                $user = new User();
                $user ->setProfil ($profil);
                $user ->setEmail ($faker->email);
                $user ->setFirstname($faker->name());
                $user ->setLastname($faker->name);
                $user ->setPhone($faker->phoneNumber);
                $user->setUsername($faker->userName);
                $user->setAdress($faker->address);

                //Génération des Users
                $password = $this->encoder->encodePassword ($user, 'pass_1234' );
                $user ->setPassword ($password );

            $manager->persist($user);

    }
        $manager->flush();
    }
}


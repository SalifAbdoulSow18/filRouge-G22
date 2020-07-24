<?php

namespace App\DataFixtures;

use App\Entity\User;
use Faker\Factory;
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
        $tab = ['admin', 'formateur', 'apprenant'];
        $tabRoles = ['ROLE_ADMIN', 'ROLE_FORMATEUR', 'ROLE_APPRENANT'];

        $tabUser = [
            [
                "firstname"=>"admin",
                "lastname"=>"admin",
                "username"=>"admin",
                "email"=>"admin@gmail.com",
                "password"=>"admin",
                "phone"=>"+221771231212",
                "adress"=>"Grand Dakar"
            ],
            [
                "firstname"=>"formateur",
                "lastname"=>"formateur",
                "username"=>"formateur",
                "email"=>"formateur@gmail.com",
                "password"=>"formateur",
                "phone"=>"+221773212121",
                "adress"=>"Dieuppeul"
            ],
            [
                "firstname"=>"apprenant",
                "lastname"=>"apprenant",
                "username"=>"apprenant",
                "email"=>"apprenant@gmail.com",
                "password"=>"apprenant",
                "phone"=>"+221771433434",
                "adress"=>"Mbao"
            ]
        ];

        for($i = 0; $i<count($tab); $i++) {

            $user = new User();
            $hash = $this->encoder->encodePassword($user,$tabUser[$i]["password"]);
            $role = [$tabRoles[$i]];

            $user->setEmail($tabUser[$i]["email"])
                 ->setFirstname($tabUser[$i]["firstname"])
                 ->setUsername($tabUser[$i]["username"])
                 ->setRoles($role)
                 ->setLastname($tabUser[$i]["lastname"])
                 ->setPhone($tabUser[$i]["phone"])
                 ->setAdress($tabUser[$i]["adress"])
                 ->setPassword($hash);

            $manager->persist($user);

        }

        $manager->flush();
    }
}

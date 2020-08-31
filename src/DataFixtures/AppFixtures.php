<?php

namespace App\DataFixtures;

use App\Entity\ProfilSortie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $profilsorties =["DEVELOPPEUR FRONT","DEVELOPPEUR BACK","DEVELOPPEUR FULLSTACK","CMS","DESIGNER","INTEGRATEUR"];

        foreach ($profilsorties as $key => $libelle){

            $profilsorti =new ProfilSortie() ;
            $profilsorti ->setLibelle ($libelle );
            $manager->persist($profilsorti);

        // $product = new Product();
        // $manager->persist($product);
    }
    $manager->flush();
}
}

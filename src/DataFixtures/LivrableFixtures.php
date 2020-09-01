<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Brief;
use App\Entity\LivrablePartiel;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ApprenantLivrablePartiel;
use Doctrine\Bundle\FixturesBundle\Fixture;

class LivrableFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');   
        // $product = new Product();
        // $manager->persist($product);
        for ($d=0; $d <2 ; $d++) {
            $apprelp = new LivrablePartiel();
            $apprelp
                ->setLibelle("livrable n° $d")
                ->setDelai(new \DateTime())
                ->setDescription("Description n° $d")
                ->setType("type n° $d")
                ->setnbreRendu(2)
                ->setNbreCorrige(1)
                
                ;
            

            $manager->persist($apprelp);

        } 

        //load brief 
$brief =new Brief ;
$brief->setLangue("Fr") 
->setNomBrief($faker->name)
->setDescription($faker->sentence)
->setContexte($faker->name) 
->setModalitePedagogique("modality") 
->setCritereDevaluation($faker->sentence())
->setModaliteDevaluation($faker->sentence())
->setImagePromo($faker->image())
->setArchiver($faker->boolean())
->setEtat($faker->sentence()) 
->setCreateAt(new \DateTime()) 
 ; 
        /* for ($i=0; $i < 2; $i++) { 
            $aplv = new ApprenantLivrablePartiel();
            $aplv
                ->setEtat("manger")
                ->setDelai(new \DateTime())
                ;
                $manager->persist($aplv);
        } */

        $manager->flush();
    }
}

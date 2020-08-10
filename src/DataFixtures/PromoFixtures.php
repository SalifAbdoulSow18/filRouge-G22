<?php

namespace App\DataFixtures;

use App\Entity\Promo;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class PromoFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $promotion = new Promo();
        $promotion
                ->setLibelle("libelle")
                ->setAnnee(new \DateTime())
                ->setDateDebut(new \DateTime())
                ->setDateFin(new \DateTime());

        $manager->persist($promotion);

        $manager->flush();
    }
}

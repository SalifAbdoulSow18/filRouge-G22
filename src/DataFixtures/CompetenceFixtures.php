<?php

namespace App\DataFixtures;

use App\Entity\Competence;
use App\Entity\GrpeCompetence;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CompetenceFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($c=1; $c <= 5 ; $c++) { 
            $gprCompetences = new GrpeCompetence();
            $gprCompetences->setLibelle("gpeCompetence n°$c");
    
            $manager->persist($gprCompetences);
    
            for ($i=0; $i < 3 ; $i++) { 
                $competences = new Competence();
                $competences->setNomCompetence("competence $i");
    
                $manager->persist($competences);
            }
        }

        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\GroupeTag;
use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TagFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($j=1; $j <= 4 ; $j++) { 
            $gprTag = new GroupeTag();
            $gprTag->setLibelle("groupeTag n°$j");
    
            $manager->persist($gprTag);
    
            for ($i=0; $i < 5 ; $i++) { 
                $tags = new Tag();
                $tags->setNomTag("tag $i");
    
                $manager->persist($tags);
            }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
}

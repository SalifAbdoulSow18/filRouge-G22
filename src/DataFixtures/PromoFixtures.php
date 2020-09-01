<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Promo;
use App\Entity\Groupe;
use App\Entity\Niveau;
use App\Entity\Profil;
use App\Entity\Apprenant;
use App\Entity\Formateur;
use App\Entity\Competence;
use App\Entity\Referentiel;
use App\Entity\GrpeCompetence;
use Doctrine\Persistence\ObjectManager;
use App\Entity\ApprenantLivrablePartiel;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PromoFixtures extends Fixture
{
    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for ($i=0; $i < 3; $i++) {
            $promotion = new Promo();
            $promotion
                    ->setLibelle("promo n°$i")
                    ->setAnnee(new \DateTime())
                    ->setDateDebut(new \DateTime())
                    ->setDateFin(new \DateTime());

            $manager->persist($promotion);
        }

        for ($p=0; $p <3 ; $p++) { 
            $gprCompetences = new GrpeCompetence();
            $gprCompetences->setLibelle("gpeCompetence n°$p");

            $competences = new Competence();
            $competences->setNomCompetence("competence $p");
            $gprCompetences->addCompetence($competences);

            $niveau = new Niveau();
            $niveau->setLevel("level $p");
            $competences->addNiveau($niveau);

            $manager->persist($gprCompetences);
        }

        for ($c=0; $c <2 ; $c++) {
            $referentiel = new Referentiel();
            $referentiel->setLibelle("Referentiel $c");
            $gprCompetences->addReferentiel($referentiel) ;


            $groupe = new Groupe() ;
            $groupe ->setPromo($promotion) 
                    ->setnomGroupe('Groupe'.$c) ; 
            $promotion->addGroupe($groupe);
            
            $manager->persist($promotion);

        }
        

            $profils =["ADMIN","FORMATEUR","APPRENANT","CM"];

            foreach ($profils as $key => $libelle){

                $profil =new Profil() ;
                $profil ->setLibelle ($libelle );
                $manager->persist($profil);
                $user = new Formateur();
                $user ->setProfil ($profil);
                $user ->setEmail ($faker->email);
                $user ->setFirstname($faker->name());
                $user ->setLastname($faker->name);
                $user ->setPhone($faker->phoneNumber);
                $user->setUsername($faker->userName);
                $user->setAdress($faker->address);

                //Génération des Users
                $password = $this->encoder->encodePassword ($user,'pass_1234');
                $user ->setPassword ($password );

                $apprenant = new Apprenant();
                $apprenant ->setProfil ($profil);
                $apprenant ->setEmail ($faker->email);
                $apprenant ->setFirstname($faker->name());
                $apprenant ->setLastname($faker->name);
                $apprenant ->setPhone($faker->phoneNumber);
                $apprenant->setUsername($faker->userName);
                $apprenant ->setAdress($faker->address);

                $password = $this->encoder->encodePassword ($apprenant,'pass_1234');
                $apprenant ->setPassword($password);

                $groupe->addApprenant($apprenant);

            }

            $promotion->addFormateur($user);
            $groupe->addFormateur($user);

            $manager->persist($profil);

        $manager->flush();
    }
}
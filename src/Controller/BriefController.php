<?php

namespace App\Controller;

use App\Entity\BriefMaPromo;
use App\Repository\ApprenantRepository;
use App\Repository\BriefMaPromoRepository;
use App\Repository\BriefRepository;
use App\Repository\PromoRepository;
use App\Repository\GroupeRepository;
use App\Repository\FormateurRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BriefController extends AbstractController
{
    /**
     * @Route("/brief", name="brief")
     */
    public function index()
    {
        return $this->render('brief/index.html.twig', [
            'controller_name' => 'BriefController',
        ]);
    }


    /**
     * @Route(
     *     name="get_brief_of_one_groupe",
     *     path="/api/formateurs/promo/{id1}/groupe/{id2}/briefs",
     *     methods={"GET"},
     *     defaults={
     *          "__controller"="App\Controller\BriefController::getBriefOfOneGroupe",
     *          "__api_resource_class"=Brief::class,
     *          "__api_collection_operation_name"="get_brief_of_one_groupe"
     *     }
     * )
     */
    public function getBriefOfOneGroupe(PromoRepository $promotionRepository,BriefRepository $briefRepository,int $id1,int $id2){

        if ( $this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_FORMATEUR') || $this->isGranted('ROLE_CM') ) {

            $tab= [];
            $promo = $promotionRepository->find($id1);

            if(!empty($promo)) {
                foreach( $promo->getGroupe() as $groupe ) {
                    if( $groupe->getId() === $id2 ) {
                        foreach( $groupe->getEtatbriefgroupe() as $etatbriefgroupe ) {
                            if($etatbriefgroupe->getStatut() === "encours") {
                                $tab[] = [
                                    "Brief"=>$briefRepository->findOneBy([ 'id' => $etatbriefgroupe->getBrief()->getId() ])
                                ];
                            }else {
                                return $this->json("Amoul groupe en cours GAYN !!");
                            }     
                        }
                        return $this->json($tab, 200, [], ["groups" => ["brief_gpe_promo"]]);
                    }
                }
                return new Response("Groupe bi Existewoul Gayn !!!");
            }
            return new Response("Promo bi existewoul GAYN !!!");
        }else {
            return $this->json("vous n'avez pas acces a ce service !!!");
        }

    }


    /**
     * @Route(
     *     name="get_brief_of_one_formateur",
     *     path="/api/formateurs/promo/{id}/briefs",
     *     methods={"GET"},
     *     defaults={
     *          "__controller"="App\Controller\BriefController::getBriefOfOneFormateur",
     *          "__api_resource_class"=Brief::class,
     *          "__api_collection_operation_name"="get_brief_of_one_formateur"
     *     }
     * )
     */
    public function getBriefOfOneFormateur(PromoRepository $promotionRepository, BriefRepository $briefRepository ,int $id) {

        if( $this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_FORMATEUR') || $this->isGranted('ROLE_CM') ) {

            $brief = [];
            $promo = $promotionRepository->find($id);

            if ( !empty($promo) ) {
                foreach( $promo->getBriefmapromo() as $briefmapromo ) {
                        $brief[] = [
                            "Briefs"=>$briefRepository->findOneBy([ 'id' => $briefmapromo->getBrief()->getId() ])
                        ];
                }
                return $this->json($brief, 200, [], ["groups" => ["brief_of_promo"]]);
            }
            return new Response("Promo bi existewoul GAYN !!!");
        }else {
            return $this->json("vous n'avez pas acces a ce service !!!");
        }
    }

    /**
     * @Route(
     *     name="get_brief_brouillon",
     *     path="/api/formateurs/{id}/briefs/brouillons",
     *     methods={"GET"},
     *     defaults={
     *          "__controller"="App\Controller\BriefController::getBriefBrouillon",
     *          "__api_resource_class"=Brief::class,
     *          "__api_collection_operation_name"="get_brief_brouillon"
     *     }
     * )
     */
    public function getBriefBrouillons(FormateurRepository $formateurRepository, BriefRepository $briefRepository, int $id) {

        if( $this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_FORMATEUR') ) {

            $briefs = [];
            $formateur = $formateurRepository->find($id);

            if ( !empty($formateur) ) {
                foreach( $formateur->getBriefs() as $brief ) {
                    if ( $brief->getEtat() === "brouillon" ) {
                        $briefs[] = [
                            "Briefs" => $briefRepository->findOneBy([ 'id' => $brief->getId() ])
                        ];
                    }
                }
                return $this->json($briefs, 200, [], ["groups" => ["brief_brouillon"]]);
            }
            return new Response("Formateur bi existewoul GAYN !!!");

        }else {
            return $this->json("vous n'avez pas acces a ce service !!!");
        }

    }


    /**
     * @Route(
     *     name="get_brief_valide",
     *     path="/api/formateurs/{id}/briefs/valide",
     *     methods={"GET"},
     *     defaults={
     *          "__controller"="App\Controller\BriefController::getBriefValide",
     *          "__api_resource_class"=Brief::class,
     *          "__api_collection_operation_name"="get_brief_valide"
     *     }
     * )
     */
    public function getBriefValide(FormateurRepository $formateurRepository, BriefRepository $briefRepository, int $id) {

        if( $this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_FORMATEUR') ) {

            $briefs = [];
            $formateur = $formateurRepository->find($id);

            if ( !empty($formateur) ) {
                foreach( $formateur->getBriefs() as $brief ) {
                    if ( $brief->getEtat() === "nonassigne" || $brief->getEtat() === "valide" ) {
                        $briefs[] = [
                            "Briefs" => $briefRepository->findOneBy([ 'id' => $brief->getId() ])
                        ];
                    }
                }
                return $this->json($briefs, 200, [], ["groups" => ["brief_brouillon"]]);
            }
            return new Response("Formateur bi existewoul GAYN !!!");

        }else {
            return $this->json("vous n'avez pas acces a ce service !!!");
        }

    }


    /**
     * @Route(
     *     name="get_brief_of_one_promo",
     *     path="/api/formateurs/promo/{id1}/briefs/{id2}",
     *     methods={"GET"},
     *     defaults={
     *          "__controller"="App\Controller\BriefController::getBriefOfOnePromo",
     *          "__api_resource_class"=Brief::class,
     *          "__api_collection_operation_name"="get_brief_of_one_promo"
     *     }
     * )
     */
    public function getBriefOfOnePromo( PromoRepository $promoRepository, BriefRepository $briefRepository, int $id1, int $id2 ) {

        $briefs = [];
        $promo = $promoRepository->find($id1);

        foreach( $promo->getBriefmapromo() as $briefmapromo ) {
            if( $briefmapromo->getBrief()->getId() === $id2 ) {
                $briefs[] = [
                    "Briefs" => $briefRepository->findOneBy([ 'id' => $briefmapromo->getBrief()->getId() ])
                ];
            }else{
                return $this->json("Groupe bi existewoul GAYN !!!");    
            }
        }
        return $this->json($briefs, 200, [], ["groups" => ["brief_of_one_promo"]]);
    }


    /**
     * @Route(
     *     name="get_brief_assigned_to_one_apprenant",
     *     path="/api/apprenants/promo/{id}/briefs",
     *     methods={"GET"},
     *     defaults={
     *          "__controller"="App\Controller\BriefController::getBriefAssignedToOneApprenant",
     *          "__api_resource_class"=Brief::class,
     *          "__api_collection_operation_name"="get_brief_assigned_to_one_apprenant"
     *     }
     * )
     */
    public function getBriefAssignedToOneApprenant(PromoRepository $promoRepository, BriefRepository $briefRepository, int $id) {

        if( $this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_FORMATEUR') || $this->isGranted('ROLE_CM') ) {

            $brief = [];
            $promo = $promoRepository->find($id);

            if ( !empty($promo) ) {
                $briefmapromo = $promo->getBriefmapromo();
                foreach($briefmapromo->getBrief() as $value ) {
                    if($value->getEtat() == "assigne") {
                        foreach( $value->getEtatbriefgroupe() as $etatbirefgroupe ) {
                            if( $etatbirefgroupe->getStaut() == "encours" ) {
                                $briefs[] = [
                                    "Briefs" => $briefRepository->findOneBy([ 'id' => $value->getId() ])
                                ];
                            }
                        }
                        return $this->json($brief, 200, [], ["groups" => ["brief_assigned"]]);
                    }
                }
            }
            return new Response("Promo bi existewoul GAYN !!!");
        }else {
            return $this->json("vous n'avez pas acces a ce service !!!");
        }

    }

    public function getBriefOfOneGroupe(PromoRepository $promotionRepository,GroupeRepository $groupesRepository,int $id1,int $id2){

        $promo=$promotionRepository->find($id1);
        $groupe=$groupesRepository->find($id2);

        for ($i=0; $i < count( $promo->getGroupe() ); $i++) { 
            
            if ( $promo->getGroupe()[$i]->getId() == $groupe->getId() ) {
                
                $etatbriefgroupe = $promo->getGroupe()[$i]->getEtatbriefgroupe();

                for ($j=0; $j < count( $etatbriefgroupe ); $j++) {

                    if ( $etatbriefgroupe[$j]->getStatut() == "encours" ) {

                        $brief = $etatbriefgroupe[$j]->getBrief();

                        $tab[]=[
                            "promo"=>[
                                "id"=>$promo->getId(),
                                "Nom_Promo"=>$promo->getLibelle(),
                                "groupe"=>[

                                    "id"=>$groupe->getId(),
                                    "Nom_Groupe"=>$groupe->getNomGroupe(),
                                    "Apprenants"=>[

                                        "id"=>$groupe->getApprenant()[$j]->getId(),
                                        "Prenom"=>$groupe->getApprenant()[$j]->getFirstname(),
                                        "Nom"=>$groupe->getApprenant()[$j]->getLastname(),
                                        "Email"=>$groupe->getApprenant()[$j]->getEmail(),
                                        "Phone"=>$groupe->getApprenant()[$j]->getPhone(),
                                        "Adress"=>$groupe->getApprenant()[$j]->getAdress(),

                                    ],
                                    "Brief"=>[

                                        "id"=>$brief->getId(),
                                        "Nom brief"=>$brief->getNombrief(),
                                        "Langue"=>$brief->getLangue(),
                                        "Description"=>$brief->getDescription(),
                                        "Contexte"=>$brief->getContexte(),
                                        "Modalite pedagogique"=>$brief->getModalitepedagogique(),
                                        "Critere d'evaluation"=>$brief->getCriteredevaluation(),
                                        "Modalite d'evaluation"=>$brief->getModalitedevaluation(),
                                        "Image promo"=>$brief->getImagepromo(),
                                        "Archiver"=>$brief->getArchiver(),
                                        "Created at"=>$brief->getCreateat(),
                                        "Etat"=>$brief->getEtat(),
                                        "Niveau"=>[
                                            "Level"=>$brief->getNiveau()[$j]->getLevel(),
                                            "Competence"=>$brief->getNiveau()[$j]->getCompetence()[$j]->getNomcompetence()
                                        ],
                                        "Livrables attendus"=>[
                                            "Libelle"=>$brief->getLivrableattendu()[$i]->getLibelle(),
                                            "Description"=>$brief->getLivrableattendu()[$i]->getDescription()
                                        ]

                                    ]
                                ]
                            ]
                        ];
                    }else {
                        return $this->json("Ce groupe est fermé desolé !!!");
                    }               
                }
            }

        }

        return $this->json($tab, 200);
        //dd($ta);
    }

}
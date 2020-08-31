<?php

namespace App\Controller;

use App\Repository\GroupeRepository;
use App\Repository\PromoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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

<?php

namespace App\Controller;

use App\Entity\Apprenant;
use App\Entity\Formateur;
use App\Entity\Commentaire;
use App\Entity\FilDeDiscussion;
use App\Entity\LivrablePartiel;
use App\Repository\BriefRepository;
use App\Repository\PromoRepository;
use App\Repository\ApprenantRepository;
use App\Repository\CompetenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CommentaireRepository;
use App\Repository\ReferentielRepository;
//use App\Controller\LivrablePartielController;
use App\Repository\BriefMaPromoRepository;
use App\Repository\LivrablePartielRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CompetencesValidesRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class LivrablePartielController extends AbstractController
{
    /**
     * @Route("/livrable/partiel", name="livrable_partiel")
     */
    public function index()
    {
        return $this->render('livrable_partiel/index.html.twig', [
            'controller_name' => 'LivrablePartielController',
        ]);
    }

    /**
     * @Route(
     *     name="get_un",
     *     path="/api/formateurs/promo/{id}/referentiel/{id_a}/competences",
     *     methods={"GET"},
     *     defaults={
     *          "__controller"="App\Controller\LivrablePartielController::getCollectionApprenant",
     *          "__api_resource_class"=LivrablePartiel::class,
     *          "__api_collection_operation_name"="get_un"
     *     }
     * )
     */
    public function getCollectionApprenant(ApprenantRepository $apprenantRepository, PromoRepository $promoRepository, ReferentielRepository $referentielRepository, int $id, int $id_a)
    {

        $promotion = $promoRepository->find($id);
        $principal = "";
        $competencesapprenant = [];
        foreach ($promotion->getGroupe() as $key => $groupe) {
            if ($groupe->getType() == "principal") {
                $principal = $groupe->getApprenant();
                foreach ($principal as $key => $apprenant) {
                    $competencesapprenant[] = [
                        "Apprenant" => [

                            [
                                "id" => $apprenant->getId(),
                                "Firstname" => $apprenant->getFirstname(),
                                "Lastname" => $apprenant->getLastname(),
                                "competences" => $apprenant->getCompetencesValides(),
                            ]
                        ]
                    ];
                }
                break;
            }
        }
        return $this->json($competencesapprenant, 200);
    }

    /**
     * @Route(
     *     name="get_un_un",
     *     path="/api/apprenant/{idl}/promo/{ida}/referentiel/{idb}/competences",
     *     methods={"GET"},
     *     defaults={
     *          "__controller"="App\Controller\LivrablePartielController::getCollectionApprenantByApp",
     *          "__api_resource_class"=LivrablePartiel::class,
     *          "__api_collection_operation_name"="get_un_un"
     *     }
     * )
     */
    public function getCollectionApprenantByApp(CompetencesValidesRepository $statRepo, PromoRepository $promoRepository, SerializerInterface $serializer, NormalizerInterface $normalize, ReferentielRepository $referentielRepository, int $ida, int $idb,int $idl)
    {

        $stats = $statRepo->findAll();
        
        foreach ($stats as $stat) {
            $promo = $stat->getPromo();
           // dd($promo);
            $apprenant = $stat->getApprenant();
           // dd($apprenant);
            if (($promo->getId() == $ida) && ($apprenant->getId() == $idl)) {
                $competence = $stat->getCompetences();
                
               // dd($competence);
               // $competenceTab = $serializer->normalize($competence, 'json', ["groups" => "competence:read"]);
              //  dd($competenceTab);
                $tab[] = ["competence" => $competence];
            }

            return $this->json($competence, 200, [], ["groups" => "competence:read"]);
        }
    }
    /**
     * @Route(
     *     name="get_deux",
     *     path="/api/formateurs/promo/{id}/referentiel/{id_b}/statistiques/competences",
     *     methods={"GET"},
     *     defaults={
     *          "__controller"="App\Controller\LivrablePartielController::getStatCompetences",
     *          "__api_resource_class"=LivrablePartiel::class,
     *          "__api_collection_operation_name"="get_deux"
     *     }
     * )
     */
    public function getStatCompetences(PromoRepository $promoRepository, CompetenceRepository $competenceRepository, int $id, int $id_b)
    {

        $competence = [];
        $promo = $promoRepository->find($id);
        $nb1 = 0;
        $nb2 = 0;
        $nb3 = 0;

        if (!empty($promo)) {

            foreach ($promo->getCompetencesValides() as $referentiel) {
                if ($referentiel->getReferentiel()->getId() === $id_b) {
                    if ($referentiel->getNiveau1() == true) {
                        $nb1 += 1;
                    }
                    if ($referentiel->getNiveau2() == true) {
                        $nb2 += 1;
                    }
                    if ($referentiel->getNiveau2() == true) {
                        $nb3 += 1;
                    }
                    $competence[] = [
                        "Competence" => $competenceRepository->findOneBY(['id' => $referentiel->getCompetences()->getId()]),
                        "niveau1" => $nb1,
                        "niveau2" => $nb2,
                        "niveau3" => $nb3

                    ];
                } else {
                    return $this->json("Ce referentiel n'existe pas !");
                }
            }
            return $this->json($competence, 200, [], ["groups" => ["promo_stat"]]);
        }
        return new Response("Cette promo n'existe pas !");
    }
    /**
     * @Route(
     *     name="get_deux_deux",
     *     path="/api/apprenants/{id}/promo/{idc}/referentiel/{ide}/statistiques/briefs",
     *     methods={"GET"},
     *     defaults={
     *          "__controller"="App\Controller\LivrablePartielController::getStatCompetences",
     *          "__api_resource_class"=LivrablePartiel::class,
     *          "__api_collection_operation_name"="get_deux_deux"
     *     }
     * )
     */
    public function getStatBrief(ApprenantRepository $apprenantRepository, PromoRepository $promoRepository, ReferentielRepository $referentielRepository, BriefRepository $briefRepository, int $id, int $idc, int $ide)
    {

        $apprenant = $apprenantRepository->find($id);
        $referentielsss = $referentielRepository->find($ide);
        $apprenants = [];
        $nbreAssigne = 0;
        $nreValid = 0;
        $nbreNonValid = 0;

        if (!empty($apprenant)) {

            foreach ($apprenant->getCompetencesValides() as $competencesvalides) {
                if ($competencesvalides->getPromo()->getId() == $idc) {
                    foreach ($competencesvalides->getReferentiel() as $referentiel) {
                        if ($referentielsss->getId() == $ide) {
                            foreach ($apprenant->getLivrableAttenduApprenants() as $key => $value) {
                                foreach ($value->getLivrableattendu()->getBriefs() as $briefs) {
                                    $statut = $briefs->getEtat();
                                    if ($statut === "valide") {
                                        $apprenants[] = [
                                            "Apprenant" => $apprenantRepository->findOneBy(['id' => $apprenant->getId()]), "Valide" => $nreValid, "Non Valide" => $nbreNonValid, "Assigne" => $nbreAssigne
                                        ];
                                        $nreValid += 1;
                                    } elseif ($statut === "non valide") {
                                        $apprenants[] = [
                                            "Apprenant" => $apprenantRepository->findOneBy(['id' => $apprenant->getId()])
                                        ];
                                        $nbreNonValid += 1;
                                    } else {
                                        $apprenants[] = [
                                            "Apprenant" => $apprenantRepository->findOneBy(['id' => $apprenant->getId()])
                                        ];
                                        $nbreAssigne += 1;
                                    }
                                }
                            }
                        }
                    }
                    return $this->json($apprenants, 200, [], ["groups" => ["apprenant_collection_competence"]]);
                }
            }
        }
    }

    /**
     * @Route(
     *     name="get_deux_it",
     *     path="/api/apprenants/{id}/livrablepartiels/{id_d}",
     *     methods={"PUT"},
     *     defaults={
     *          "__controller"="App\Controller\LivrablePartielController::putAppLiv",
     *          "__api_resource_class"=LivrablePartiel::class,
     *          "__api_item_operation_name"="get_deux_it"
     *     }
     * )
     */
    public function putAppLiv(Request $request, EntityManagerInterface $manager, ApprenantRepository $apprenantRepository, LivrablePartielRepository $livrablePartielRepository, int $id, int $id_d)
    {

        $etatTab = json_decode($request->getContent(), true);

        $apprenant = $apprenantRepository->findOneBY(["id" => $id]);

        $livrapartiel = $livrablePartielRepository->findoneBY(["id" => $id_d]);

        if (!$apprenant) {
            return new JsonResponse("L'apprenant dont l'id=" . $id . "n'existe pas", Response::HTTP_CREATED, [], true);
        }
        if (!$livrapartiel) {
            return new JsonResponse("Le livrable dont l'id=" . $id_d . "n'existe pas", Response::HTTP_CREATED, [], true);
        }
        foreach ($apprenant->getApprenantLivrablePartiels() as $apl) {
            $apl->setEtat($etatTab['etat']);
        }
        $manager->flush();
        return $this->json("Modification reussi");
    }

    /**
     * @Route(
     *     name="post_formateur",
     *     path="/api/formateurs/livrablepartiels/{id}/commentaires",
     *     methods={"POST"},
     *     defaults={
     *          "__controller"="App\Controller\LivrablePartielController::postAjoutFilDu",
     *          "__api_resource_class"=LivrablePartiel::class,
     *          "__api_item_operation_name"="post_formateur"
     *     }
     * )
     */
    public function  postAjoutFilDu(SerializerInterface $serializer, EntityManagerInterface $manager, Request $request, TokenStorageInterface $token, LivrablePartielRepository $livrablePartielRepository, CommentaireRepository $commentaireRepository, int $id)
    {
        $discussion = json_decode($request->getContent(), true);

        if (!isset($discussion['commentaire'])) {
            return new JsonResponse("Ajouter des commentaires au fil de discussion", Response::HTTP_BAD_REQUEST, [], true);
        }
        $livpar = $livrablePartielRepository->findOneBY(["id" => $id]);

        $user = $token->getToken()->getUser();

        if (!$livpar) {
            return new JsonResponse("Le livrable partiel dont l'id=" . $id . "n'existe pas", Response::HTTP_BAD_REQUEST, [], true);
        }
        // foreach ($livpar->getApprenantLivrablePartiels() as $key => $appreliv) {

        if ($user instanceof Formateur || $user instanceof Apprenant) {
            // $filDeDisscussion= $appreliv->getFilDeDiscussion();
            $fil = new FilDeDiscussion();
            if (isset($discussion['titreFil'])) {

                $fil->setTitre($discussion['titreFil']);
                $fil->setDate(new  \DateTime());
            }

            foreach ($discussion['commentaire'] as $commentaire) {

                $com = new Commentaire();
                $com->setDescription($commentaire['description'])
                    ->setCreateAt(new \DateTime())
                    ->setFilDeDiscussion($fil);
                if ($user instanceof Formateur) {
                    $com->setFormateur($user);
                }
                $manager->persist($com);
            }
            $manager->persist($fil);
        }
        // }
        $manager->flush();
        return new JsonResponse("Fil de discussion et commentaires ajoutés", Response::HTTP_BAD_REQUEST, [], true);
    }

    /**
     * @Route(
     *     name="get_formateur_com",
     *     path="/api/formateurs/livrablepartiels/{id}/commentaires",
     *     methods={"GET"},
     *     defaults={
     *          "__controller"="App\Controller\LivrablePartielController::getCom",
     *          "__api_resource_class"=LivrablePartiel::class,
     *          "__api_item_operation_name"="get_formateur_com"
     *     }
     * )
     */

    public function getCom(LivrablePartielRepository $livrablePartielRepository, int $id)
    {

        $livrable = $livrablePartielRepository->findOneBy(
            [
                "id" => $id
            ]
        );
        if (!$livrable) {
            return new JsonResponse("Le livrable partiel dont l'id=" . $id . "n'existe pas", Response::HTTP_BAD_REQUEST, [], true);
        }
        $TabCommentaires = [];

        foreach ($livrable->getApprenantlivrablepartiel() as $partiel) {

            foreach ($partiel->getFildediscussion()->getCommentaires() as $commentaire) {
                $TabCommentaires[] = $commentaire;
            }
        }

        return $this->json(["Commentaires" => $TabCommentaires], 200, [], ["groups" => "commentaires"]);
    }

    /**
     * @Route(
     *     name="modiflivrable",
     *      path="/api/formateurs/promo/{idp}/briefs/{idb}/livrablePartiels",
     *      methods={"PUT"}
     * )
     */
    public function editLivrablePartielByFormateur(Request $request,$idp, $idb, BriefMaPromoRepository $repoBriefMaPromo,BriefRepository $repoBrief,PromoRepository $repoPromo,LivrablePartielRepository $repoLV,EntityManagerInterface $em)
    {
        if ( $this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_FORMATEUR') ) {
            $json = json_decode($request->getContent());
           //dd($json);
            $promo=$repoPromo->find($idp);
            $brief=$repoBrief->find($idb);
            $livrableP=$repoLV->findAll();
            foreach($promo->getBriefmapromo() as $briefdupromo){
                if ($briefdupromo->getBrief()->getId()==$brief->getId() && $briefdupromo->getPromo()->getId()==$promo->getId()) {
                    if($json->ajout==true){
                        $livrablePartiel=new LivrablePartiel();
                        $livrablePartiel->setDelai(new \DateTime())
                                        ->setLibelle($json->libelle)
                                        ->setDescription($json->description)
                                        ->setType($json->type)
                                        ->setDeleted($json->deleted)
                                        ->setBriefmapromo($briefdupromo);
                        $em->persist($livrablePartiel);
                    }
                    foreach($livrableP as $value){
                        if($value->getId()==($json->deletedId)){
                            $value->setDeleted(true);
                        }
                    }
                    $em->flush();
                    return $this->json("success",Response::HTTP_OK);
                }
            }        
            return $this->json("brief ou promo inexistant");
        }
    }


}

<?php

namespace App\Controller;

use App\Entity\Referentiel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReferentielController extends AbstractController
{
    /**
     * @Route("/referentiel", name="referentiel")
     */
    public function index()
    {
        return $this->render('referentiel/index.html.twig', [
            'controller_name' => 'ReferentielController',
        ]);
    }

    /**
     * @Route(
     *      name="referentiel_gpecompetence",
     *      path="api/admin/referentiels",
     *      methods={"POST"}
     * )
     */
    public function addCompetence(SerializerInterface $serializer,Request $request,ValidatorInterface $validator) {

        if ($this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_FORMATEUR') || $this->isGranted('ROLE_CM')) {
            //Recuperation du contenue body de la requette
            $referentielJson = $request->getContent();
            $referentiels = $serializer->deserialize($referentielJson,Referentiel::class,'json');
            $gpecompetence = $referentiels->getGrpeCompetence();

            if(count($gpecompetence) == 0) {
                return $this->json("Bindeul bene gpe competence gayn");
            }
            //Validation des données
            $errors = $validator->validate($referentiels);
            if (count($errors) > 0) {
                $errorsString =$serializer->serialize($errors,"json");
                return new JsonResponse( $errorsString ,Response::HTTP_BAD_REQUEST,[],true);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($referentiels);
            $entityManager->flush();
            return new JsonResponse("succes",Response::HTTP_CREATED,[],true);
        }else {
            return $this->json(" you don't haave access to this !!!");
        }        

    }

}

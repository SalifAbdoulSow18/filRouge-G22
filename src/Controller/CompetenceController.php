<?php

namespace App\Controller;

use App\Entity\Competence;
use App\Entity\GrpeCompetence;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\JsonLoginFactory;

class CompetenceController extends AbstractController
{
    /**
     * @Route("/competence", name="competence")
     */
    public function index()
    {
        return $this->render('competence/index.html.twig', [
            'controller_name' => 'CompetenceController',
        ]);
    }

    /**
     * @Route(
     *      name="grpcompetence_competence",
     *      path="api/admin/grpecompetences",
     *      methods={"POST"}
     * )
     */
    public function addGpeCompetence(SerializerInterface $serializer,Request $request,ValidatorInterface $validator) {

        if ($this->isGranted('ROLE_ADMIN')) {
            //Recuperation du contenue body de la requette
            $gpecompetenceJson = $request->getContent();
            $gpecompetences = $serializer->deserialize($gpecompetenceJson,GrpeCompetence::class,'json');
            $competence = $gpecompetences->getCompetences();

            if(count($competence) == 0) {
                return $this->json("Bindeul bene competence gayn");
            }
            //Validation des données
            $errors = $validator->validate($gpecompetences);
            if (count($errors) > 0) {
                $errorsString =$serializer->serialize($errors,"json");
                return new JsonResponse( $errorsString ,Response::HTTP_BAD_REQUEST,[],true);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($gpecompetences);
            $entityManager->flush();
            return new JsonResponse("succes",Response::HTTP_CREATED,[],true);
        }else {
            return $this->json(" you don't have access to this !!!");
        }        

    }

    /**
     * @Route(
     *      name="competence_niveau",
     *      path="api/admin/competences",
     *      methods={"POST"}
     * )
     */
    public function addCompetence(SerializerInterface $serializer,Request $request,ValidatorInterface $validator) {

        if ($this->isGranted('ROLE_ADMIN')) {
            //Recuperation du contenue body de la requette
            $competenceJson = $request->getContent();
            $competences = $serializer->deserialize($competenceJson,Competence::class,'json');
            $niveau = $competences->getNiveaux();

            if(count($niveau) == 0) {
                return $this->json("Bindeul bene niveau gayn");
            }
            //Validation des données
            $errors = $validator->validate($competences);
            if (count($errors) > 0) {
                $errorsString =$serializer->serialize($errors,"json");
                return new JsonResponse( $errorsString ,Response::HTTP_BAD_REQUEST,[],true);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($competences);
            $entityManager->flush();
            return new JsonResponse("succes",Response::HTTP_CREATED,[],true);
        }else {
            return $this->json(" you don't haave access to this !!!");
        }        

    }

}

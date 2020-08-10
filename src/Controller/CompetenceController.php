<?php

namespace App\Controller;
 
use App\Entity\Competence;
use App\Repository\CompetenceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route; 
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CompetenceController extends AbstractController
{
    
        
    public function __invoke(SerializerInterface $serializer,EntityManagerInterface $entityManager,CompetenceRepository $repo, $id)
    {
        $regionsObject = $entityManager->getRepository(Competence::class)->find($id); 

            $users=$repo->findByid($id) ;
            dd($users) ;
        foreach($users as $user){
               //dd($user) ;
            $entityManager->persist($user);
            $entityManager->flush();
        }
        dd($user) ; 
        // $regionsObject=$repo->findByCompetence($id) ; 
        // $regionsJson =$serializer->serialize($regionsObject, "json",
        // [    
        //     "groups"=>["competence:read"]                                     //for avoit reference circular
        // ]);
            
        // return new JsonResponse($regionsJson,Response::HTTP_OK,[],true);
    }

 
}

<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ApiPlatform\Core\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

     /**
     * @Route("/api/apprenants", name="api_add_apprenant", methods={"POST"})
     */
    public function addApprenant(SerializerInterface $serializer,Request $request,ValidatorInterface $validator)
    {
        //Recuperation du contenue body de la requette
        $apprenantJson = $request->getContent();
        $apprenant = $serializer->deserialize($apprenantJson,User::class,'json');
        //Validation des données
        $errors = $validator->validate($apprenant);
        if (count($errors) > 0) {
            $errorsString =$serializer->serialize($errors,"json");
            return new JsonResponse( $errorsString ,Response::HTTP_BAD_REQUEST,[],true);
            }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($apprenant);
        $entityManager->flush();
        return new JsonResponse("succes",Response::HTTP_CREATED,[],true);
    }   



    //Seuls Les Formateurs/CM Peuvent Lister les Apprenants!!!
    public function showApprenant(UserRepository $repo)
    {
        if ($this->isGranted('ROLE_FORMATEUR')|| $this->isGranted('ROLE_CM') ) {
            $apprenants= $repo->findByProfil("APPRENANT");
            return $this->json($apprenants,Response::HTTP_OK,);
        }
        else{
            return $this->json("Access denied!!!");
        }
        
    }

    //Seuls Les Formateurs/CM/APPRENANTS Peuvent Lister un Apprenant Par Son ID!!!
    public function showApprenantById(UserRepository $repo, $id)
    {
        if ($this->isGranted('ROLE_FORMATEUR')|| $this->isGranted('ROLE_CM') || $this->isGranted('ROLE_APPRENANT') ) {
            $apprenants= $repo->findByProfilById("APPRENANT",$id);
            return $this->json($apprenants,Response::HTTP_OK,);
        }
        else{
            return $this->json("Access denied!!!");
        }
        
    }

   //Seul Le CM Peut Lister Les Formateurs!!!
    public function showFormateur(UserRepository $repo)
    {if ($this->isGranted('ROLE_CM') ) {
        $formateurs= $repo->findByProfil("FORMATEUR");
        return $this->json($formateurs,Response::HTTP_OK,);
    }
    else{
        return $this->json("Access denied!!!");              
        }
    }

    public $tokenStorage;
 
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    //Seuls Les Formateurs/CM Peuvent Lister un Formateur Par Son ID!!!
    public function showFormateurById(UserRepository $repo, $id)
    {
        $token = $this->getUser()->getId() ;
       
        dd($token) ;
       
        if ($this->isGranted('ROLE_FORMATEUR') || $this->isGranted('ROLE_CM') ) {
            $formateurs= $repo->findByProfilById("FORMATEUR",$id);
            return $this->json($formateurs,Response::HTTP_OK,);
        }
        else{
            return $this->json("Access denied!!!1");
        }
        
    }
    
}

<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;

class UserController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

     
    public function addApprenant(SerializerInterface $serializer,Request $request,ValidatorInterface $validator)
    {
        if ($this->isGranted('ROLE_ADMIN')) {
        //Recuperation du contenue body de la requette
        $apprenantJson = $request->getContent();
        $apprenant = $serializer->deserialize($apprenantJson,APPRENANT::class,'json');
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
    }else {
        return $this->json(" you don't haave access to this !!!");
    }
    }   



    //Seuls Les Formateurs/CM/ADMIN Peuvent Lister les Apprenants!!!
    public function showApprenant(UserRepository $repo)
    {
        if ($this->isGranted('ROLE_ADMIN')||$this->isGranted('ROLE_FORMATEUR')|| $this->isGranted('ROLE_CM') ) {
            $apprenants= $repo->findByProfil("APPRENANT");
            return $this->json($apprenants,Response::HTTP_OK,);
        }
        else{
            return $this->json("Access denied!!!");
        }
        
    }

    //Seuls Les Admins/Formateurs/CM Peuvent Lister un Apprenant Par Son ID!!!
    // Show Apprenant informations Only and Admin Formateur CM !!!

    public function showApprenantById( UserRepository $repo, $id ) {

        if ( $this->isGranted('ROLE_APPRENANT') ) {
            $idApprenant = $this->getUser()->getId();
            $apprenan = $repo->findByProfilById("APPRENANT", $id);

            if ( $idApprenant == $id ) {
                return $this->json($apprenan, Response::HTTP_OK,);
            }else {
                return $this->json("Vous n'avez pas acces à ce profil, désolé !!!");
            }
        }elseif( $this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_FORMATEUR') || $this->isGranted('ROLE_CM') ) {
            $apprenan = $repo->findByProfilById("APPRENANT", $id);
            return $this->json($apprenan, Response::HTTP_OK,);
        }else {
            return $this->json("Acces non autorisé !!!");
        }

    }

   //Seul Le CM/Admin Peut Lister Les Formateurs!!!
    public function showFormateur(UserRepository $repo)
    {
        if ($this->isGranted('ROLE_ADMIN')||$this->isGranted('ROLE_CM') ) {
        $formateurs= $repo->findByProfil("FORMATEUR");
        return $this->json($formateurs,Response::HTTP_OK,);
    }
    else{
        return $this->json("Access denied!!!");
    }
    }


    //Seuls Les /Admin/Formateurs/CM Peuvent Lister un Formateur Par Son ID!!!
    public function showFormateurById(UserRepository $repo, $id)
    {
        if ( $this->isGranted('ROLE_FORMATEUR') ) {
            $idFormateur = $this->getUser()->getId();
            $formateur = $repo->findByProfilById("FORMATEUR", $id);

            if ( $idFormateur == $id ) {
                return $this->json($formateur, Response::HTTP_OK,);
            }else {
                return $this->json("Vous n'avez pas acces à ce profil, désolé !!!");
            }
        }elseif( $this->isGranted('ROLE_ADMIN') || $this->isGranted('ROLE_CM') ) {
            $formateur = $repo->findByProfilById("FORMATEUR", $id);
            return $this->json($formateur, Response::HTTP_OK,);
        }else {
            return $this->json("Acces non autorisé !!!");
        }

        
    }


   

    
}

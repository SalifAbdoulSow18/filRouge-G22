<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use ApiPlatform\Core\Validator\ValidatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
 * @Route(
 * name="apprenant_liste",
 * path="api/apprenants",
 * methods={"GET"},
 * defaults={
 *      "_controller"="\app\ControllerApprenantController::showApprenant",
 *      "_api_resource_class"=User::class,
 *      "_api_collection_operation_name"="get_apprenants"
 * }
 * )
 */
    public function showApprenant(UserRepository $repo)
    {
        $apprenants= $repo->findByProfil("APPRENANT");
        return $this->json($apprenants,Response::HTTP_OK,);
    }

    
}

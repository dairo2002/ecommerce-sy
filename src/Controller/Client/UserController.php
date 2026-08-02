<?php

namespace App\Controller\Client;

use App\Entity\Usuarios;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    #[Route('/user', name: 'app_client_user')]
    public function index(): Response
    {        
        return $this->render('client/users.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    
    #[Route('/user/signup', name: 'app_client_user_signup', methods: ['POST'])]
    public function signUp (Request $request, UserPasswordHasherInterface $hasherPwd): JsonResponse {        
        $data = json_decode($request->getContent(), true);          

        $name = $data['name'] ?? null;
        $lastName = $data['lastName'] ?? null;
        $password = $data['password'] ?? null;
        $passwordConfirm = $data['passwordConfirm'] ?? null;

        if (trim($password) !== trim($passwordConfirm)) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Las contraseñas no conciden'
            ], Response::HTTP_BAD_REQUEST);          
        }

        $username = strtolower($name . $lastName); 

        $rUser = new Usuarios();
        
        $rUser->setNombre($name);
        $rUser->setApellido($lastName);
        $rUser->setTelefono($data['phone'] ?? null);
        $rUser->setCorreoelectronico($data['email'] ?? null);
        $rUser->setUsername($username);
        $rUser->setPassword(
            $hasherPwd->hashPassword($rUser, $password)
        );
        $rUser->setFecharegistro(new DateTime());

        $this->em->persist($rUser);
        $this->em->flush(); 
        
        return new JsonResponse([
            'success' => true,
            'message' => 'Se registro correctamente el usuario'
        ], Response::HTTP_CREATED);
    }
}

<?php

namespace App\Controller\Client;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_client_user')]
    public function index(): Response
    {        
        return $this->render('client/users.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
}

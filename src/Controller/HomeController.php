<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    public function animales(){
        $title = "Vista de animales";
        $animlas = ['Perro', 'Tigre', 'Paloma', 'Rata'];

        return $this->render('home/animales.html.twig', [
            "titulo"   => $title,
            "animales" => $animlas                
        ]);
    }

    public function redirigir(){
        return $this->redirectToRoute('app_home');
    }
}

<?php

namespace App\Controller;

use App\Entity\Categoria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $em;    

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function index(): Response
    {
        $allCategory = $this->em->getRepository(Categoria::class)->findAll();
        return $this->render('home/index.html.twig', [
            'allCategory' => $allCategory,
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

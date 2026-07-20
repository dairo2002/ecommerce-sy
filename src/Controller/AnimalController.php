<?php

namespace App\Controller;

use App\Entity\Animales;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimalController extends AbstractController
{

    #[Route('/animales', name: 'app_animales', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('/home/animales.html.twig', [
            'controller_name' => 'AnimalControllerrr',
        ]);
    }

    public function save(EntityManagerInterface $em) {

        $animal = New Animales();
        $animal->setTipo("Camello");
        $animal->setColor("Cafe");
        $animal->setRaza("afrino");

        $em->persist($animal);
        $em->flush();

        return new Response($animal->getRaza());
    }
}

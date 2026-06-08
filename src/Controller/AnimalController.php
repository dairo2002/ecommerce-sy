<?php

namespace App\Controller;

use App\Entity\Animales;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class AnimalController extends AbstractController
{
    public function index(): Response
    {
        return $this->render('animal/index.html.twig', [
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

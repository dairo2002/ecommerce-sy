<?php

namespace App\Controller\Admin;

use App\Entity\Categoria;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoriasController extends AbstractController
{    
    /** @var EntityManagerInterface */
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/categorias', name: 'app_admin_categorias', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('admin/categorias/index.html.twig');
    }

    #[Route('/categorias/add', name: 'app_categoria_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse {        
        $data = json_decode($request->getContent(), true);        
        
        $fechainicio = ($data["fechainicio"] ? new DateTime() : null);
        $fechafin = ($data["fechafin"] ? new DateTime() : null);    

        $categoria = new Categoria;
        $categoria->setNombre($data["categoria"]);
        $categoria->setDescuento($data["descuento"]);
        $categoria->setFecharegistro(new DateTime());
        $categoria->setFechainicio($data["fechainicio"] ? new \DateTime($data["fechainicio"]) : null);
        $categoria->setFechafin($data["fechafin"] ? new \DateTime($data["fechafin"]) : null);

        $this->em->persist($categoria);
        $this->em->flush();

        return $this->json([
            'success'  => true,
            'message' => 'Categoria agregada exitosamente'
        ], 201);
    }
}
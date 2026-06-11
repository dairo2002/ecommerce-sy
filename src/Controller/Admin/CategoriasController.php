<?php

namespace App\Controller\Admin;

use PHPUnit\Util\Json;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json as ConstraintsJson;

class CategoriasController extends AbstractController
{    
    public function index(): Response
    {
        return $this->render('admin/categorias/index.html.twig');
    }

    public function create(): JsonResponse {
        return json_decode('');
    }
}

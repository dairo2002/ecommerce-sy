<?php

namespace App\Controller\Admin;

use App\Entity\Productos;
use App\DTO\Admin\ProductDto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Flex\Response;

class ProductosController extends AbstractController
{
    /** @var EntityManagerInterface  */
    private $em;

    /** @var SluggerInterface */
    private $slugger;

    public function __construct(EntityManagerInterface $em, SluggerInterface $slug) {
        $this->em = $em;
        $this->slugger = $slug;
    }

    public function index()
    {
        return $this->render('admin/productos/index.html.twig');
    }

    public function createProducts(Request $request, ValidatorInterface $validador): JsonResponse
    {
        
        $dto = new ProductDto(
            $request->request->get('nombre'),
            $request->request->get('stock'),
            $request->request->get('descripcion'),
            $request->files->get('imagen')
        );        

        $errors = $validador->validate($dto);
        if (count($errors) > 0) {
            
            $error = [];
            
            foreach ($errors as $e) {
                $error[$e->getPropertyPath()] = $e->getMessage();
            }

            return $this->json([
                'success' => false,
                'error'   => $error
            ], 422 );

        }

        $product = new Productos;
        $product->setNombre($dto->nombre);
        $product->setDescripcion($dto->descripcion);
        $product->setImagen($dto->imagen);
        $product->setStock($dto->stock);
        $product->setSlug($dto->nombre);

        $this->em->persist($product);
        $this->em->flush();       
       
        return $this->json([
            'success'  => true,
            'message' => 'Producto guardado exitosamente'
        ], 201);
    }
}

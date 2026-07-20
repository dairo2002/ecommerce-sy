<?php

namespace App\Service;

use App\Entity\ItemCarrito;
use App\Entity\Productos;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class CartService {

    private $em;

    public function __construct(EntityManagerInterface $em) {
        $this->em = $em;
    }

    public function add(array $data): JsonResponse {        
        $productId = $data['productId'] ?? null;
        $quantity  = $data['quantity'] ?? null;
        
        $product = $this->em->getRepository(Productos::class)->find($productId);        

        if (!$product) {
            throw new \Exception("Ha ocurrido un error");            
        }

        try {
             
            $entity = new ItemCarrito();
            $entity->setIdproducto($product);
            $entity->setCantidad($quantity);
            $entity->setSubtotal(0);            

            $this->em->persist($entity);
            $this->em->flush();

            return new JsonResponse([
                'status' => 'success',
                'message' => 'Producto agregado al carrito'
            ], 200);

        } catch (\Throwable $th) {
            throw new \Exception("Ha ocurrido un error ". $th->getMessage());            
        }

    }



}
<?php

namespace App\Service;

use App\Entity\ItemCarrito;
use App\Entity\Productos;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Config\DoctrineMigrations\StorageConfig;

class CartService {

    const SESSION_KEY = "item_cart";
    
    private $em;
    private $requestStack;

    public function __construct(EntityManagerInterface $em, RequestStack $requestStack) {
        $this->em = $em;
        $this->requestStack = $requestStack;
    }

    public function load(): array {
        $cart = $this->requestStack->getSession()->get(self::SESSION_KEY);
        return is_array($cart) ? $cart : [];
    }

    public function addItem(int $productId, int $quantity)  {
        $product = $this->em->getRepository(Productos::class)->find($productId);

        $store = $this->load();

        if (isset($store[$product->getId()])) {
            $store[$product->getId()]['cantidad'] += $quantity;
            $store[$product->getId()]['subtotal'] = round($product->getPrecio() * $store[$product->getId()]['cantidad']);
                
        } else {
            $store[$product->getId()] = [
                'id'          => $product->getId(),
                'nombre'      => $product->getNombre(),
                'precio'      => $product->getPrecio(),
                'cantidad'    => $quantity,
                'imagen'      => $product->getImagen(),
                'descripcion' => $product->getDescripcion(),
                'subtotal'    => round($product->getPrecio() * $quantity)                
            ];
        } 
    
        return $store;
    }

    public function add(array $data): void {
        $productId = $data['productId'] ?? null;
        $quantity  = $data['quantity'] ?? null;
    
        $store = $this->addItem($productId, $quantity);        
        $this->requestStack->getSession()->set(self::SESSION_KEY, $store);        
    }

    public function delete(int $productId){
        $store = $this->load();
        if (isset($store[$productId])) {
            unset($store[$productId]);
        }

        $this->requestStack->getSession()->set(self::SESSION_KEY, $store);

        return $store;
    }

    public function getTotal(): float {
        $total = 0;    
        $store = $this->load();

        foreach ($store as $row) {
            $total += $row['subtotal'];
        }
        
        return $total;
    }

    public function getTotalItem() {
        return count($this->load());
    }


}
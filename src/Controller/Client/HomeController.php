<?php

namespace App\Controller\Client;

use App\Entity\Categoria;
use App\Entity\Productos;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $em;    
    private $cart;

    public function __construct(
        EntityManagerInterface $em, 
        CartService $cart,
    ) {
        $this->em = $em;
        $this->cart = $cart;        
    }

    public function index(): Response
    {
        $allProducts = $this->em->getRepository(Productos::class)->findAll();
        $allCategory = $this->em->getRepository(Categoria::class)->findAll();

        return $this->render('client/home.html.twig', [
            'allProducts' => $allProducts,          
            'allCategory' => $allCategory
        ]);
    }

    #[Route('home/cart/add', name: 'app_admin_home', methods: ['GET', 'POST'])]
    public function addProductCart(Request $request): JsonResponse {
        $data = json_decode($request->getContent(), true);
        $this->cart->add($data);
        return new JsonResponse([
            'success' => true,
            'message' => 'Producto agregado correctamente al carrito'
        ]);
    }

    #[Route('home/cart/list', name: 'cart_list', methods: ['GET'])]
    public function listProducts(): JsonResponse {
        $store = $this->cart->load();
        $totalCart = $this->cart->getTotal();       
        $countItem = $this->cart->getTotalItem();
    
        return new JsonResponse([
            'itemsCart' => array_values($store),
            'countItem' => $countItem,
            'total'     => $totalCart
        ]);
    }

    #[Route('home/cart/delete/{productId}', name: 'cart_delete', methods: ["DELETE"])]
    public function deleteProducts($productId) {    
        return $this->cart->delete(intval($productId));
    }

    #[Route('/home/searchAll', name: 'search_autocomplete', methods: ["GET"])]
    public function autoCompleteAll(Request $request): JsonResponse {        
        $search = $request->query->get('search');        
        $result = $this->em->getRepository(Productos::class)->serchAll($search);
        return new JsonResponse(['search' => $result]);
    }

    #[Route('/home/detalle/{productId}', name: 'search_detalle_producto', methods: ["GET"])]
    public function detailProduct($productId): JsonResponse {                
        $result = $this->em->getRepository(Productos::class)->findProductsWithCategory($productId);
        // print_r($result).die();
        return new JsonResponse(['search' => $result]);
    }


}

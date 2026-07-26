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

    public function __construct(EntityManagerInterface $em, CartService $cart) {
        $this->em = $em;
        $this->cart = $cart;
    }

    public function index(): Response
    {
        $allCategory = $this->em->getRepository(Categoria::class)->findAll();
        $allProducts = $this->em->getRepository(Productos::class)->findAll();                

        return $this->render('client/home.html.twig', [
            'allCategory' => $allCategory,
            'allProducts' => $allProducts            
        ]);
    }

    #[Route('home/cart/add', name: 'app_admin_home', methods: ['GET', 'POST'])]
    public function addProductCart(Request $request) {
        $data = json_decode($request->getContent(), true);
        return $this->cart->add($data);        
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
}

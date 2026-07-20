<?php

namespace App\Controller;

use App\Entity\Categoria;
use App\Entity\ItemCarrito;
use App\Entity\Productos;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $allItemCart = $this->em->getRepository(ItemCarrito::class)->findAll();

        return $this->render('home/index.html.twig', [
            'allCategory' => $allCategory,
            'allProducts' => $allProducts,
            'itemCart'    => $allItemCart
        ]);
    }

    #[Route('/home/cart/add', name: 'app_admin_home', methods: ['GET', 'POST'])]
    public function addProductCart(Request $request, CartService $cart) {
        $data = json_decode($request->getContent(), true);
        return $this->cart->add($data);        
    }

    
    /*
    #[Route('/categorias', name: 'app_admin_categorias', methods: ['GET', 'POST'])]
    public function index(): Response
    {
        return $this->render('admin/categorias/index.html.twig');
    }

    #[Route('/categorias/add', name: 'app_categoria_create', methods: ['POST'])]

    */

}

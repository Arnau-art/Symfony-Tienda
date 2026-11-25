<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\CartService;
use App\Service\ProductsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/cart')]
class CartController extends AbstractController
{
    private $repository;
    private $productsService;
    private $cart;

    public function __construct(ProductRepository $repository, ProductsService $productsService, CartService $cart)
    {
        $this->repository = $repository;
        $this->productsService = $productsService;
        $this->cart = $cart;
    }

    #[Route('', name: 'app_cart', methods: ['GET'])]
    public function index(): Response
    {
        $items = $this->repository->getFromCart($this->cart);

        return $this->render('cart/index.html.twig', compact('items'));
    }

    #[Route('/add', name: 'cart_add', methods: ['POST'])]
    public function cart_add(Request $request): JsonResponse
    {
        $id = $request->request->getInt('id');
        $product = $this->productsService->getProduct($id);
        if (!$product) {
            return new JsonResponse([], JsonResponse::HTTP_NOT_FOUND);
        }

        $this->cart->add($id, 1);

        $data = $this->productsService->toCartItem($product);
        $data['totalItems'] = $this->cart->totalItems();

        return $this->json($data, JsonResponse::HTTP_CREATED);
    }
}
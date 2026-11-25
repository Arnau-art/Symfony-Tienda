<?php
namespace App\Service;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService{
    private const KEY = '_cart';
    private $requestStack;
    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }
    public function getSession()
    {
        return $this->requestStack->getSession();
    }
    public function getCart(): array {
        return $this->getSession()->get(self::KEY, []);
    }
    public function add(int $id, int $quantity = 1){
        $cart = $this->getCart();
        //Sólo añadimos si no lo está 
        if (!array_key_exists($id, $cart))
            $cart[$id] = $quantity;
        $this->getSession()->set(self::KEY, $cart);
    }
    public function totalItems(): int
{
    return array_sum($this->getCart());
}
}

<?php

namespace App\Service;

use App\Entity\Product;
use App\Repository\ProductRepository;

class ProductsService
{
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getProducts(): array
    {
        return $this->repository->findAll();
    }

    public function getProduct(int $id): ?Product
    {
        return $this->repository->find($id);
    }

    public function toArray(Product $product): array
    {
        return [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'photo' => $product->getPhoto(),
            'price' => $product->getPrice(),
        ];
    }
    public function toCartItem(Product $product): array{
    $item = $this->toArray($product);
    // Por defecto es 0
    $item["quantity"] = $this->cart->getCart()[$product->getId()] ?? 0;
    return $item;
}   

}
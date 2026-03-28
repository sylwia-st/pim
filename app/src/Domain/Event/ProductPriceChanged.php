<?php
declare(strict_types = 1);

namespace App\Domain\Event;

use App\Entity\Product;

class ProductPriceChanged
{
    private Product $product;
    private string  $oldPrice;
    private string  $newPrice;

    public function __construct(Product $product, string $oldPrice, string $newPrice)
    {
        $this->product  = $product;
        $this->oldPrice = $oldPrice;
        $this->newPrice = $newPrice;
    }

    public function getProduct()
    : Product
    {
        return $this->product;
    }

    public function getOldPrice()
    : string
    {
        return $this->oldPrice;
    }

    public function getNewPrice()
    : string
    {
        return $this->newPrice;
    }
}

<?php

namespace App\Messaging\Notification;

use App\Entity\Product;

class NotificationMessage
{
    public const PRODUCT_WARNING = 10;
    public const PRODUCT_LOW = 20;

    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
}

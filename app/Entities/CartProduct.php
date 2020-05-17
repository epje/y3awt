<?php namespace App\Entities;

use CodeIgniter\Entity;

class CartProduct extends Entity
{
    protected $id;
    protected $cart_id;
    protected $product_id;
    protected $quantity;

}
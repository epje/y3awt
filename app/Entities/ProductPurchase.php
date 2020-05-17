<?php namespace App\Entities;

use CodeIgniter\Entity;

class ProductPurchase extends Entity
{
    protected $id;
    protected $product_id;
    protected $purchase_id;
    protected $quantity;

}
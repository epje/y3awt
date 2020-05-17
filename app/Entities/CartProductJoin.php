<?php namespace App\Entities;

use CodeIgniter\Entity;

class CartProductJoin extends Entity
{
    // Product
    protected $id;
    protected $name;
    protected $description;
    protected $price;
    protected $category;
    protected $img;

    // CartProduct
    protected $quantity;

}
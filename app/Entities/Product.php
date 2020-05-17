<?php


namespace App\Entities;


use CodeIgniter\Entity;

class Product extends Entity
{
    protected $id;
    protected $name;
    protected $description;
    protected $price;
    protected $category;
    protected $img;

}
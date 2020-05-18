<?php namespace App\Entities;

use CodeIgniter\Entity;

class Purchase extends Entity
{
    protected $id;
    protected $client_id;
    protected $status;
    protected $grand_total;

    // Derived attributes
    protected $product_quantity;

}
<?php namespace App\Entities;

use CodeIgniter\Entity;

class Client extends Entity
{
    protected $id;
    protected $first_name;
    protected $last_name;
    protected $title;
    protected $phone;
    protected $email;
    protected $password;

}
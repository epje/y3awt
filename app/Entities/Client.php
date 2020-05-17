<?php namespace App\Entities;

use CodeIgniter\Entity;

class Client extends Entity
{
    protected int $id;
    protected $first_name;
    protected $last_name;
    protected $title;
    protected $phone;
    protected $email;
    protected $password;
    protected $last_login;

}
<?php


namespace App\Models;


use App\Entities\Client;

class CartProductJoinModel extends BaseModel
{


    protected $table = 'cartproduct';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\CartProductJoin';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name', 'email'];

    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;


    public function readContentsAll(Client $client)
    {
        $cartModel = new CartModel();
        $cart = $cartModel->getCart($client);
        return $this
            ->select('*')
            ->where('cart_id', $cart->id)
            ->join('product', 'product.id = cartproduct.product_id')
            ->findAll();
    }

}
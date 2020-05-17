<?php


namespace App\Models;


use App\Entities\Client;

class ClientPurchasesModel extends BaseModel
{

    protected $table = 'purchase';
    protected $primaryKey = 'id';

    protected $returnType = 'array';
    protected $useSoftDeletes = true;

    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function readPurchasesByClient(Client $client)
    {
        echo $this
            ->where('purchase.client_id', $client->id)
            ->join('productpurchase', 'productpurchase.purchase_id = purchase.id')
            ->join('product', 'productpurchase.product_id = product.id')
            ->getCompiledSelect();
    }

}
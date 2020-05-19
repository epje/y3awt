<?php namespace App\Models;

use App\Entities\Client;
use App\Entities\Purchase;

class ProductPurchaseJoinProductModel extends BaseModel
{
    protected $table = 'productpurchase';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\ProductPurchaseJoinProduct';
    protected $useSoftDeletes = true;

    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;

    public function readByPurchaseID(Purchase $purchase)
    {
        return $this
            ->select('*')
            ->where('productpurchase.purchase_id', $purchase->id)
            ->join('product', 'productpurchase.product_id = product.id')
            ->findAll();
    }

    public function readAllPurchases()
    {
        return $this
            ->select()
            ->join('product', 'productpurchase.product_id = product.id')
            ->findAll();
    }

}
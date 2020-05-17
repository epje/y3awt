<?php


namespace App\Models;


use App\Entities\CartProduct;
use App\Entities\ProductPurchase;
use App\Entities\Purchase;

class ProductPurchaseModel extends BaseModel
{
    protected $table = 'productpurchase';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\ProductPurchase';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'purchase_id',
        'product_id',
        'quantity'
    ];

    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;


    //region CREATE METHODS

    public function createProductPurchase(Purchase $purchase, CartProduct $cartProduct)
    {
        log_message('debug', '[DEBUG] ' . __NAMESPACE__ . 'ProductPurchaseModel - createProductPurchase() called.');
        // Purchase(purchase_id), CartProduct(product_id, quantity).
        $productPurchase = new ProductPurchase([
            'purchase_id' => $purchase->id,
            'product_id' => $cartProduct->product_id,
            'quantity' => $cartProduct->quantity
        ]);

        try {
            return $this->insert($productPurchase);
        } catch (\ReflectionException $e) {
            log_message('error', '[ERROR] {e}', ['e' => $e]);
            return false;
        }
    }

    //endregion


    //region READ METHODS

    //endregion


    //region UPDATE METHODS



    //endregion


    //region DELETE METHODS

    //endregion


}
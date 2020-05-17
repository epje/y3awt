<?php namespace App\Models;

use App\Entities\Cart;
use App\Entities\CartProduct;
use App\Entities\Product;

/**
 * Class CartProductModel
 * @package App\Models
 * @todo Update with regions, phpdoc for functions & logs for each function call.
 */
class CartProductModel extends BaseModel
{
    protected $table = 'cartproduct';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\CartProduct';
    protected $useSoftDeletes = true;

    // Fields that can be operated on with insert / update queries.
    protected $allowedFields = [
        'cart_id',
        'product_id',
        'quantity'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'cart_id' => 'required|numeric',
        'product_id' => 'required|numeric',
        'quantity' => 'required|numeric'
    ];

    /*
     * CREATE
     */

    /**
     * @param Cart $cart
     * @param Product $product
     * @param $quantity
     * @return bool|int|string
     * @todo Updating products to sum the quantities.
     */
    public function createProduct(Cart $cart, Product $product, $quantity)
    {
        log_message('debug', '[DEBUG] createProduct() called in CartProductModel.');
        /*
         * 1. Check if the CartProduct already exists in db.
         * 2. If no, use insert.
         * 3. If yes, use update.
         */

        // Create the CartProduct row for the db.
        $cartProduct = new CartProduct([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => $quantity
        ]);


        if ($this->exists($cartProduct)) {
            log_message('debug', '[DEBUG] Cart with id [{cart_id}] already has Product with id [{product_id}].', ['cart_id' => $cart->id, 'product_id' => $product->id]);
            try {
                $cartProduct = $this->readByCP($cartProduct)[0];
                $cartProduct->quantity += $quantity;
                if ($cartProduct->quantity < 1) {
                    return false;
                }
                return $this->update($cartProduct->id, $cartProduct);
            } catch (\ReflectionException $e) {
                log_message('error', '[ERROR] {e}', ['e' => $e]);
            }
        } else {
            try {
                return $this->insert($cartProduct);
            } catch (\ReflectionException $e) {
                log_message('error', '[ERROR] {e}', ['e' => $e]);
            }
        }
        return false;
    }

    /*
     * READ
     */

    /**
     * @param CartProduct $cartProduct
     * @return bool
     */
    public function exists(CartProduct $cartProduct)
    {
        if (!empty($this->readByCP($cartProduct))) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param CartProduct $cartProduct
     * @param bool $asArray
     * @return array|object|null
     */
    public function readByCP(CartProduct $cartProduct, bool $asArray = false)
    {
        log_message('debug', '[DEBUG] readByCP() called in CartProductModel.');
        if ($asArray) {
            return $this
                ->asArray()
                ->where('cart_id', $cartProduct->cart_id)
                ->where('product_id', $cartProduct->product_id)
                ->find();
        } else {
            return $this
                ->where('cart_id', $cartProduct->cart_id)
                ->where('product_id', $cartProduct->product_id)
                ->find();
        }
    }

    /**
     * @param Cart $cart
     * @return array
     * @todo give this a once over.
     */
    public function getProducts(Cart $cart)
    {
        log_message('debug', '[DEBUG] getProducts(Cart({cart})) called in CartProductModel.', ['cart' => $cart->id]);
        return $this
            ->select(['product_id', 'quantity'])
            ->where('cart_id', $cart->id)
            ->findAll();
    }

    public function getProductsJoined(Cart $cart)
    {
        return $this
            ->asArray()
            ->select()
            ->join('product', 'cart.product_id = product.id')
            ->findAll();
    }

    /*
     * UPDATE
     */

    /**
     * @param Cart $cart
     * @param Product $product
     * @param $quantity
     * @return bool
     */
    protected function updateProduct(Cart $cart, Product $product, $quantity)
    {
        log_message('debug', '[DEBUG] updateProduct() called in CartProductModel.');
        $row = $this->readByCP($cart, $product);
        $cartProduct = new CartProduct([
            'cart_id' => $cart->id,
            'product_id' => $product->id,
            'quantity' => $quantity
        ]);

        try {
            return $this->update($cartProduct);
        } catch (\ReflectionException $e) {
            log_message('error', '[ERROR] {e}', ['e' => $e]);
        }
        log_message('debug', '[DEBUG] updateProduct() returned false in CartProductModel.');
        return false;
    }


    //region DELETE

    /**
     * @param Cart $cart The cart from which to delete all products.
     * @return bool|mixed|string Whether the deletion for all
     */
    public function deleteProductsByCartID(Cart $cart)
    {
        return $this
            ->where('cart_id', $cart->id)
            ->delete();
    }

    /**
     * @param Cart $cart The cart from which to delete the given product.
     * @param Product $product The product which should be deleted.
     * @return bool|mixed|string
     */
    public function deleteProduct(Cart $cart, Product $product)
    {
        return $this
            ->where('cart_id', $cart->id)
            ->where('product_id', $product->id)
            ->delete();
    }

    //endregion
}
<?php namespace App\Models;

use App\Entities\Cart;
use App\Entities\CartProduct;
use App\Entities\Client;
use App\Entities\Product;

/**
 * Class CartModel
 * @package App\Models
 * @author 17003804
 * @todo Create logs for each function call + get list of products in cart as JSON.
 */
class CartModel extends BaseModel
{
    protected $table = 'cart';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\Cart';
    protected $useSoftDeletes = true;

    // Fields that can be operated on with insert / update queries.
    protected $allowedFields = [
        'client_id'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $skipValidation = false;
    protected $validationRules = [
        'client_id' => 'required'
    ];

    //region CREATE METHODS

    /**
     * @param Client $client The client whose cart you want to add a product to.
     * @param Product $product The product you would like to add to the cart.
     * @param int $quantity The number of the products to add to the cart.
     * @return bool|int|string
     */
    public function addProduct(Client $client, Product $product, int $quantity)
    {
        log_message('debug', '[DEBUG] \\' . __NAMESPACE__ . '\CartModel - addProduct() called.');
        $cart = $this->getCart($client);
        $cartProductModel = new CartProductModel();
        return $cartProductModel->createProduct($cart, $product, $quantity);
    }

    //endregion

    //region READ METHODS

    /**
     * @param Client $client
     * @return array|bool|object|null
     */
    public function getCart(Client $client)
    {
        // 1. Check if user has cart already.
        // a. If not, create one and pass back.
        // b. If yes, pass back.
        // 2. Return the cart.
        if (!$this->cartExists($client)) {
            // The client does not have a cart.
            log_message('debug', '[DEBUG] \\' . __NAMESPACE__ . '\CartModel - Client with id [{id}] does not have a cart.', ['id' => $client->id]);
            try {
                // Create a new cart row for the client.
                log_message('debug', '[DEBUG] \\' . __NAMESPACE__ . '\CartModel - Creating cart for client with id [{id}].', ['id' => $client->id]);
                $cart = new Cart([
                    'client_id' => $client->id
                ]);
                if ($this->insert($cart)) {
                    // Return the cart to the caller.
                    return $this->readCartByClientID($client);
                } else {
                    log_message('error', '[ERROR] \\' . __NAMESPACE__ . '\CartModel - Cart creation for client with id [{id}] failed - insert() returned false.', ['id' => $client->id]);
                    return false;
                }
            } catch (\ReflectionException $e) {
                log_message('error', '[ERROR] {exception}', ['exception' => $e]);
                return false;
            }
        } else {
            // The cart already exists so return to caller.
            log_message('debug', '[DEBUG] \\' . __NAMESPACE__ . '\CartModel - Client with id [{id}] already has a cart.', ['id' => $client->id]);
            return $this->readCartByClientID($client);
        }
    }

    public function cartEmpty(Client $client)
    {
        $products = $this->readContents($client);
        return empty($products);
    }

    /**
     * @param Client $client
     * @return bool Whether the client's cart exists in the database.
     */
    protected function cartExists(Client $client): bool
    {
        $rows = $this
            ->where('client_id', $client->id)
            ->countAllResults();
        if ($rows > 1) {
            log_message('ERROR', '[ERROR] \\' . __NAMESPACE__ . '\CartModel - Client with id [{id}] has {num} carts!', ['num' => $rows]);
        }
        return ($rows === 1);
    }

    /**
     * @param Client $client The client whose cart you would like.
     * @return array|object|null
     */
    protected function readCartByClientID(Client $client)
    {
        return $this
            ->where('client_id', $client->id)
            ->first();
    }

    public function readContents(Client $client)
    {
        $cart = $this->getCart($client);

        $cartProductModel = new CartProductModel();
        /** @noinspection PhpParamsInspection */
        return $cartProductModel->getProducts($cart);

    }



    //endregion

    //region UPDATE METHODS

    /**
     * @param Client $client
     * @param Product $product
     * @param int $quantity
     * @todo this
     */
    public function updateProduct(Client $client, Product $product, int $quantity)
    {
        log_message('debug', '[DEBUG] \\' . __NAMESPACE__ . '\CartModel - updateProduct() called.');
        if ($quantity == 0) {
            return $this->deleteProduct($client, $product);
        } else {

        }
    }

    //endregion

    //region DELETE METHODS

    /**
     * @param Client $client
     * @return array|bool
     * @todo Finish HTTP return codes
     */
    public function checkout(Client $client)
    {
        if ($this->cartEmpty($client)) return ['status' => 404, 'code' => 404, 'message' => ['error' => 'The cart is empty.']];

        $cart = $this->getCart($client);
        $products = $this->readContents($client);
        $purchaseModel = new PurchaseModel();
        if ($purchase = $purchaseModel->getPurchase($client)) {

            $productPurchaseModel = new ProductPurchaseModel();

            log_message('debug', '[DEBUG] \\' . __NAMESPACE__ . '\CartModel - Entering foreach(cart as product)');
            foreach ($products as $product) {
                log_message('debug', '[DEBUG] \\' . __NAMESPACE__ . '\CartModel - foreach(cart({cart}) as product({product}))', ['cart' => $cart->id, 'product' => $product->id]);
                if (!$productPurchaseModel->createProductPurchase($purchase, $product)) {
                    return false;
                }
            }
            if (!$purchaseModel->closePurchase($client)) {
                return false;
            }

            if (!$this->deleteCart($client)) {
                return false;
            }
            // No failures so return true;
            return true;

        } else {
            log_message('error', '[ERROR] \\' . __NAMESPACE__ . '\CartModel - Failed $purchaseModel->getPurchase()');
            return false;
        }
    }

    /**
     * @param Client $client
     * @return bool If the cart was successfully deleted or not.
     */
    public function deleteCart(Client $client)
    {
        log_message('debug', '[DEBUG] \\' . __NAMESPACE__ . '\CartModel - deleteCart($client->{id}) called.', ['id' => $client->id]);
        /*
         * 1. Check if cart exists.
         * 2. If no, return false;?
         * 3. If yes, CPM->deleteProducts(Cart $cart).
         * 4. Delete Cart row. (4&5 w/ soft deletes).
         * (DB uses CASCADE!)
         */
        if ($this->cartExists($client)) {
            $cart = $this->readCartByClientID($client);
            $cartProductModel = new CartProductModel();

            /** @noinspection PhpParamsInspection */
            $cartProductsDeleted = $cartProductModel->deleteProductsByCartID($cart);
            $cartDeleted = $this->delete($cart->id);

            // Return if both the cart products and cart were deleted successfully.
            return ($cartProductsDeleted && $cartDeleted);
        } else {
            return false;
        }
    }

    /**
     * @param Client $client
     * @param Product $product
     * @return bool|mixed|string
     * @todo Check product exists in cart first.
     */
    public function deleteProduct(Client $client, Product $product)
    {
        $cart = $this->getCart($client);
        $cartProductModel = new CartProductModel();

        $cartProduct = new CartProduct([
            'cart_id' => $cart->id,
            'product_id' => $product->id
        ]);

        if (!$cartProductModel->exists($cartProduct)) {
            return false;
        }

        /** @noinspection PhpParamsInspection */
        return $cartProductModel->deleteProduct($cart, $product);
    }

    //endregion


}
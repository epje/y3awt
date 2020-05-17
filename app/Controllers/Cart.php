<?php namespace App\Controllers;

use App\Entities\Client;
use App\Entities\Product;

use App\Models\CartModel;
use App\Models\CartProductJoinProductModel;
use App\Models\ClientModel;
use App\Models\ProductModel;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\Response;

class Cart extends ParentController
{
    use ResponseTrait;

    public function index()
    {
        $products = $this->get();

        if ($products instanceof Response) {
            if ($products->getStatusCode() == 404) {
                return redirect()->to('cart/empty');
            } else {
                return $products;
            }
        }

        $cartPrice = 0;
        foreach ($products as $product) {
            $cartPrice += $product->price;
        }

        $taxRate = getenv('app.taxRate');
        $checkoutData = [
            'products' => $products,
            'subtotal' => number_format($cartPrice, 2),
            'tax_rate' => $taxRate,
            'tax_value' => number_format($taxRate * $cartPrice, 2),
            'grand_total' => number_format((($taxRate * $cartPrice) + $cartPrice), 2)
        ];
        $headerData = [
            'title' => 'Checkout',
            'author' => '17003804',
            'description' => 'Checkout Page',
            'keywords' => ['checkout', 'total', 'price'],
            'copyright' => '17003804 &copy; 2020'
        ];

        echo view('templates/header', $headerData);
        echo view('cart/cart', $checkoutData);
        echo view('templates/footer');

    }

    /**
     * @return mixed Returns array with contents of cart or 404 when empty.
     */
    private function get()
    {
        if (!$this->session->get('loggedIn')) {
            return $this->failUnauthorized('Please log in to access the cart.');
        }

        // Create a new client object from session.
        $clientModel = new ClientModel();
        $client = new Client($clientModel->readByID(new Client(['id' => $this->session->get('clientID')]), true));

        // Get the contents of the cart.
        $cartModel = new CartModel();
        $cart = $cartModel->readContents($client);

        // If the cart has no products return a 404 and empty message.
        if (empty($cart)) {

            return $this->failNotFound('Cart is empty.');
        }

        $cartProductJoin = new CartProductJoinProductModel();
        return $cartProductJoin->readContentsAll($client);

    }

    /**
     * @param int $productID
     * @param int $quantity
     * @return Client[]|Product[]|array|Response|mixed
     */
    public function add(int $productID, int $quantity = 1)
    {
        // Check the quantity is valid.
        if ($quantity < 1) {
            return $this->failValidationError('Invalid quantity supplied.');
        }

        $prepResult = $this->prepare($productID, true, true);

        // Check if the result was a HTTP response (failure).
        if ($prepResult instanceof Response) {
            return $prepResult;
        } else {
            $client = $prepResult['client'];
            $product = $prepResult['product'];
        }


        // Product exists so try and add it to the cart.
        $cartModel = new CartModel();
        if ($cartModel->addProduct($client, $product, $quantity)) {
            log_message('debug', '[DEBUG] addProduct() called from Cart.');
            return $this->respondCreated([
                'status' => 200,
                'message' => [
                    'success' => 'Product added successfully.'
                ]
            ]);
        } else {
            return $this->failValidationError('Failed to add product to cart.');
        }
    }

    /**
     * @return Client[]|Product[]|array|Response|mixed
     */
    public function delete()
    {
        $prepResult = $this->prepare(null, true, true);

        // Check if the result was a HTTP response (failure).
        if ($prepResult instanceof Response) {
            return $prepResult;
        } else {
            $client = $prepResult['client'];
        }

        // Product exists so try and add it to the cart.
        $cartModel = new CartModel();
        if ($response = $cartModel->deleteCart($client)) {
            return $this->respondDeleted($response, 'Cart deleted.');
        } else {
            return $this->failNotFound('No cart exists to be deleted.');
        }
    }

    /**
     * @param $productID
     * @param null $quantity
     * @return bool|mixed
     */
    public function remove($productID, $quantity = null)
    {
        $prepResult = $this->prepare($productID, true, true);

        // Check if the result was a failure response.
        if ($prepResult instanceof Response) {
            return $prepResult;
        } else {
            $client = $prepResult['client'];
            $product = $prepResult['product'];
        }

        $cartModel = new CartModel();
        if (isset($quantity)) {
            // Doing a negative add (bit cheeky but works!)
            if ($cartModel->addProduct($client, $product, -$quantity)) {
                $data = [
                    'status' => 200,
                    'code' => 200,
                    'messages' => [
                        'Product quantity altered.'
                    ]
                ];
                return $this->respondDeleted($data);
            }
        } else {

            if ($cartModel->deleteProduct($client, $product)) {
                $data = [
                    'status' => 200,
                    'code' => 200,
                    'messages' => [
                        'Product removed from cart.'
                    ]
                ];
                return $this->respondDeleted($data);
            }
        }
        return $this->failNotFound('Product not found in cart.');
    }

    public function update(int $productID, int $quantity)
    {
        $prepResult = $this->prepare($productID, true, true, false);

        // Check if the result was a failure response.
        if ($prepResult instanceof Response) {
            return $prepResult;
        } else {
            $product = $prepResult['product'];
            $client = $prepResult['client'];
        }


    }

    public function checkoutPost()
    {
        if ($this->request->getMethod() == 'post') {

            $prepResult = $this->prepare(null, true, true, false);

            // Check if the result was a failure response.
            if ($prepResult instanceof Response) {
                return $prepResult;
            } else {
                $client = $prepResult['client'];
            }

            $cartModel = new CartModel();
            if ($cartModel->checkout($client)) {
                return redirect()->to('/client/purchases');
            }
        }
    }

    public function empty()
    {
        $headerData = [
            'title' => 'Checkout',
            'author' => '17003804',
            'description' => 'Checkout Page',
            'keywords' => ['checkout', 'total', 'price'],
            'copyright' => '17003804 &copy; 2020'
        ];
        echo view('templates/header', $headerData);
        echo view('cart/empty');
        echo view('templates/footer');
    }


    /**
     * @param int $productID Used to check if the product exists.
     * @param bool $authRequired Whether to check if the client is logged in (usually true).
     * @param bool $clientRequired Whether to get the client from the database.
     * @param bool $requireAJAX
     * @return Client[]|Product[]|array|Response|mixed
     */
    private function prepare(int $productID = null, bool $authRequired = true, bool $clientRequired = true, bool $requireAJAX = false)
    {
        $result = [];

        // If the request must be made from AJAX.
        if ($requireAJAX) {
            if (!$this->request->isAJAX()) {
                return $this->failServerError('Request not made from AJAX.');
            }
        }

        if ($authRequired) {
            if (!$this->session->get('loggedIn')) {
                return $this->failUnauthorized('You must be logged in to use the cart.');
            }
        }

        if ($clientRequired) {
            // Create a new client object from session.
            $clientModel = new ClientModel();
            $client = new Client($clientModel->readByID(new Client(['id' => $this->session->get('clientID')]), true));
            $result += ['client' => $client];
        }

        if (isset($productID)) {
            // Create a new product object from the ID.
            $product = new Product(['id' => $productID]);
            $productModel = new ProductModel();
            // If the product does not exist in the db then fail.
            if (!$productModel->exists($product)) {
                return $this->failNotFound('Product does not exist.');
            }
            $result += ['product' => $product];
        }

        return $result;
    }

}
<?php


namespace App\Controllers;


use App\Entities\Client;
use App\Models\ClientModel;
use App\Models\ProductModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\Response;

class Product extends ParentController
{
    use ResponseTrait;

    //region CREATE METHODS


    //endregion

    //region [READ METHODS]

    public function id(int $productID)
    {
        $prepResult = $this->prepare($productID, null, false);

        // Check if the result was a HTTP response (failure).
        if ($prepResult instanceof Response) {
            return $prepResult;
        } else {
            $product = $prepResult['product'];
        }
        $productModel = new ProductModel();
        $product = $productModel->readByID($product);
        return $this->respond($product[0]);
    }

    public function category(string $category)
    {
        $prepResult = $this->prepare(null, $category);

        // Check if the result was a HTTP response (failure).
        if ($prepResult instanceof Response) {
            return $prepResult;
        } else {
            $product = $prepResult['product'];
        }
        $productModel = new ProductModel();
        $product = $productModel->readByCategory($product);
        return $this->respond($product);

    }

    public function all()
    {
        $productModel = new ProductModel();
        return $this->respond($productModel->findAll());
    }

    //endregion

    //region [UPDATE METHODS]


    //endregion

    //region [DELETE METHODS]


    //endregion

    //region [HELPER METHODS]

    /**
     * @param int $productID Used to check if the product exists.
     * @param string|null $productCategory
     * @param bool $requireAJAX
     * @return Client[]|\App\Entities\Product[]|array|Response|mixed
     */
    private function prepare(int $productID = null, string $productCategory = null, bool $requireAJAX = false)
    {
        $result = [];

        // If the request must be made from AJAX.
        if ($requireAJAX) {
            if (!$this->request->isAJAX()) {
                return $this->failServerError('Request does not appear to be made using AJAX.');
            }
        }

        // Check whether the product exists.
        if (isset($productID)) {
            // Create a new product object from the ID.
            $product = new \App\Entities\Product(['id' => $productID]);
            $productModel = new ProductModel();
            // If the product does not exist in the db then fail.
            if (!$productModel->exists($product)) {
                return $this->failNotFound('Product does not exist.');
            }
            $result += ['product' => $product];
        }

        if (isset($productCategory)) {
            // Create a new product object from the ID.
            $product = new \App\Entities\Product(['category' => $productCategory]);
            $productModel = new ProductModel();
            // If the product does not exist in the db then fail.
            if (empty($productModel->readByCategory($product))) {
                return $this->failNotFound('No products found in this category.');
            }
            $result += ['product' => $product];
        }

        return $result;
    }

    //endregion

}
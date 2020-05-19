<?php namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Files\Exceptions\FileNotFoundException;

class Catalog extends ParentController
{
    public function index()
    {
        // Show list of all products.
        $data = [
            'title' => 2
        ];

        echo view('templates/header', $data);
        echo view('templates/footer');
    }

    public function product($productID)
    {
        $product = new \App\Entities\Product(['id' => $productID]);

        $productModel = new ProductModel();
        $product = $productModel->readByID($product);

        if (!isset($product)) {
            throw new PageNotFoundException('Product not found!');
        }

        $keywords = ['product', 'view'];
        $headerMeta = [
            'title' => $product->name,
            'author' => '17003804',
            'description' => 'viewing a product',
            'keywords' => $keywords,
            'copyright' => '(C) 17003804'
        ];

        $productData = [
            'product' => $product
        ];

        echo view('templates/header', $headerMeta);
        echo view('catalog/product', $productData);
        echo view('templates/footer');

    }

    public function category($category = 'all')
    {
        // If a category was passed in URL, set it.
        if (($category)) {
            $product = new \App\Entities\Product(['category' => $category]);
        }

        // Get products from that category.
        $productModel = new ProductModel();
        $products = $productModel->readByCategory($product);

        // Shuffle() the products in a random order.
        shuffle($products);

        if (empty($products)) {
            throw new PageNotFoundException('No products found in this category.', 404);
        }
        // View products in specified category.

        $keywords = ['product', 'catalog', $product->category];
        $headerData = [
            'title' => ucfirst($product->category),
            'author' => '17003804',
            'description' => 'Catalog',
            'keywords' => $keywords,
            'copyright' => '(C) 17003804'
        ];

        $categoryData = [
            'category' => $category,
            'products' => $products
        ];


        echo view('templates/header', $headerData);
        echo view('catalog/category', $categoryData);
        echo view('templates/footer');


    }

}
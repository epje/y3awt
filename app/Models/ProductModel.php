<?php

namespace App\Models;

use App\Entities\Product;

class ProductModel extends BaseModel
{

    protected $table = 'product';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\Product';
    protected $useSoftDeletes = true;

    protected $allowedFields = [
        'name',
        'description',
        'price',
        'category',
        'img_path',
        'rating'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $skipValidation = false;
    protected $validationRules = [
        'id' => 'is_not_unique[product.id]',
        'name' => 'required',
        'description' => 'required',
        'price' => 'required|numeric',
        'category' => 'required|in_list[bathroom,bedroom,dining,kitchen,living,office]'
    ];
    protected $validationMessages = [
        'name' => [
            'required' => 'The product name is required.'
        ],
        'description' => [
            'required' => 'The product description is required.'
        ],
        'price' => [
            'required' => 'The product price is required.',
            'numeric' => 'The product price must be a number.'
        ],
        'category' => [
            'required' => 'The product category is required.',
            'in_list' => 'That product category does not exist.'
        ]
    ];


    /*
     * CREATE
     */

    /*
     * READ
     */

    public function exists(Product $product): bool
    {
        $rows = $this
            ->where(['id' => $product->id])
            ->countAllResults();
        return ($rows == 1);
    }

    public function readByCategory(Product $product)
    {
        if ($product->category == 'all') {
            return $this
                ->select([
                    'id',
                    'name',
                    'description',
                    'price',
                    'category',
                    'img',
                    'rating'
                ])
                ->findAll();
        } else {
            return $this
                ->select([
                    'id',
                    'name',
                    'description',
                    'price',
                    'category',
                    'img',
                    'rating'
                ])
                ->where('category', $product->category)
                ->findAll();
        }
    }

    public function readByID(Product $product)
    {
        return $this
            ->where('id', $product->id)
            ->find();
    }

    // TODO: Return ALL products.


    /*
     * UPDATE
     */

    /*
     * DELETE
     */


}
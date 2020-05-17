<?php


namespace App\Controllers;


use App\Models\PurchaseModel;
use CodeIgniter\API\ResponseTrait;

class API extends ParentController
{
    use ResponseTrait;

    public function orders($id = null)
    {
        $model = new PurchaseModel();

        return $model->findAll();

    }

    public function users($input = null)
    {
        $this->response->setStatusCode(400);
        $users = [
            'hash' => hash('MD5', $input),
            'varadasds' => ['a', 'b']
        ];
        $this->response->setJSON($users);
        return $this->response;
    }

}
<?php namespace App\Controllers;

use App\Entities\Purchase;
use App\Models\ClientModel;
use App\Models\ProductPurchaseJoinProductModel;
use App\Models\PurchaseModel;
use CodeIgniter\API\ResponseTrait;

class API extends ParentController
{
    use ResponseTrait;

    public function purchases(int $id = null)
    {
        // Check if the user is logged
        if ($this->session->get('loggedIn')) {
            $clientModel = new ClientModel();
            $client = $clientModel->readByID(new \App\Entities\Client(['id' => $this->session->get('clientID')]));
            if (!$clientModel->isStaff($client)) return $this->failUnauthorized('You are not authorised to use the API.');


            $productPurchaseJoinProductModel = new ProductPurchaseJoinProductModel();
            if ($id) {
                if ($id < 1) {
                    return $this->failValidationError('Purchase ID must be greater than 0!', 'invalidParameter');
                }
                $purchase = new Purchase(['id' => $id]);
                if ($result = $productPurchaseJoinProductModel->readByPurchaseID($purchase)) {
                    return $this->respond($result);
                } else {
                    return $this->failNotFound('No purchases found by that ID.', 'notFound');
                }
            } else {
                if ($result = $productPurchaseJoinProductModel->readAllPurchases()) {
                    $purchasesArray = [];
                    $purchaseModel = new PurchaseModel();
                    if ($purchases = $purchaseModel->findAll()) {
                        foreach ($purchases as $purchase) {
                            $purchaseResult = $productPurchaseJoinProductModel->readByPurchaseID($purchase);
                            array_push($purchasesArray, $purchaseResult);
                        }
                    }
                    return $this->respond($purchasesArray);
                } else {
                    return $this->failNotFound('No purchases found in database.', 'notFound');
                }
            }
        } else {
            return $this->failUnauthorized('You are not authorised to use the API.');
        }
    }
}
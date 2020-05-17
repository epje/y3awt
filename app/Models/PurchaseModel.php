<?php namespace App\Models;

use App\Entities\Client;
use App\Entities\Purchase;

use CodeIgniter\Model;

class PurchaseModel extends BaseModel
{
    protected $table = 'purchase';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\Purchase';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['client_id', 'status'];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = true;


    //region CREATE METHODS

    /**
     * @param Client $client
     * @return array|bool|object|null
     */
    public function create(Client $client)
    {
        if ($this->exists($client)) {
            return $this->readByClientSingle($client, 'open');
        } else {
            $purchase = new Purchase([
                'client_id' => $client->id,
                'status' => 'open'
            ]);
            try {
                $this->insert($purchase);
            } catch (\ReflectionException $e) {

                log_message('error', '[ERROR] {exception}', ['exception' => $e]);
                return false;
            }
        }
    }

    //endregion


    //region READ METHODS

    public function exists(Client $client)
    {
        if (!empty($this->readByClientSingle($client, 'open'))) {
            return true;
        } else {
            return false;
        }
    }

    public function getPurchase(Client $client)
    {
        if (!$this->exists($client)) {
            // The client does not have an open purchase.
            log_message('debug', '[DEBUG] Client with id [{id}] does not have a cart.', ['id' => $client->id]);
            $purchase = new Purchase([
                'client_id' => $client->id
            ]);
            try {
                // Create a new purchase row for the client.
                log_message('debug', '[DEBUG] Creating new purchase for client with id [{id}]', ['id' => $client->id]);
                if ($this->insert($purchase)) {
                    // Return the purchase to the caller.
                    return $this->readByClientSingle($client, 'open');
                }
            } catch (\ReflectionException $e) {
                log_message('error', '[ERROR] {exception}', ['exception' => $e]);
                return false;
            }
        } else {
            // The client already has an open purchase so return it.
            // TODO: This might not be the way to do it, as maybe adding products in loop - might not be a problem here, but could potentially be somewhere else (Maybe in product purchase model).
            log_message('debug', '[DEBUG] PurchaseModel.php - Client with id [{id}] already has an open purchase.', ['id' => $client->id]);
            return $this->readByClientSingle($client, 'open');
        }
    }

    /**
     * @param Client $client
     * @param string $status
     * @return array|object|null The current purchase that is marked as open (by default).
     */
    public function readByClientSingle(Client $client, string $status = 'open')
    {
        return $this
            ->where('client_id', $client->id)
            ->where('status', $status)
            ->first();
    }

    /**
     * @param Client $client
     * @return array An array of clients' purchases that are marked as closed.
     */
    public function readByClientAll(Client $client)
    {
        return $this
            ->where('client_id', $client->id)
            ->where('status', 'closed')
            ->findAll();
    }

    public function readByClientIDPurchaseID(Client $client, Purchase $purchase)
    {
        return $this
            ->where('client_id', $client->id)
            ->where('id', $purchase->id)
            ->first();
    }

    public function readPrice(Purchase $purchase)
    {
        $productPurchaseModel = new ProductPurchaseModel();
        $products = $this->read
    }

    public function readByID(Purchase $purchase)
    {
        return $this->find($purchase->id);
    }

    //endregion


    //region UPDATE METHODS

    public function closePurchase(Client $client)
    {
        log_message('debug', '[DEBUG] \\' . __NAMESPACE__ . '\PurchaseModel - closePurchase(client->{id}) called.', ['id' => $client->id]);
        $purchase = $this->getPurchase($client);
        $purchase->status = 'closed';
        log_message('debug', 'lll');
        try {
            return $this->update($purchase->id, $purchase);
        } catch (\ReflectionException $e) {
            log_message('error', '[ERROR] {e}', ['e' => $e]);
        }
    }

    //endregion


    //region DELETE METHODS

    //endregion


//    public function read($id)
//    {
//        return $this
//            ->find($id);
//    }
//
//    public function readByUser($id)
//    {
//        return $this
//            ->asArray()
//            ->where('user_id', $id);
//
//    }
//
//    public function readByStatus($status)
//    {
//        return $this
//            ->asArray()
//            ->where('status', $status);
//
//    }


}
<?php

namespace App\Models;

use App\Entities\Client;
use CodeIgniter\Model;

class ClientModel extends BaseModel
{
    // Relevant table and primary key names.
    protected $table = 'client';
    protected $primaryKey = 'id';

    protected $returnType = 'App\Entities\Client';
    protected $useSoftDeletes = true;

    // Fields that can be operated on with insert / update queries.
    protected $allowedFields = [
        'first_name',
        'last_name',
        'title',
        'phone',
        'email',
        'password'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $skipValidation = false;
    protected $validationRules = [
        'first_name' => 'required|max_length[255]',
        'last_name' => 'required|max_length[255]',
        'title' => 'required|max_length[255]',
        'phone' => 'required|exact_length[10]|numeric',
        'email' => 'required|valid_email|max_length[255]',
        'password' => 'required|min_length[8]'
    ];
    protected $validationMessages = [
        'first_name' => [
            'required' => 'You must enter your first name.',
            'max_length' => 'Your first name cannot be longer than 255 characters.'
        ],
        'last_name' => [
            'required' => 'You must enter your last name.',
            'max_length' => 'Your last name cannot be longer than 255 characters.'
        ],
        'title' => [
            'required' => 'You must enter your title.',
            'max_length' => 'Your title cannot be longer than 255 characters.',
        ],
        'phone' => [
            'required' => 'You must enter your phone number.',
            'exact_length' => 'Your phone number must be exactly 10 digits.',
            'numeric' => 'Your phone number can only contain numbers.',
            'is_unique' => 'This phone number is registered to an existing account.'
        ],
        'email' => [
            'required' => 'You must enter your email.',
            'valid_email' => 'Your email must be a valid email address.',
            'max_length' => 'Your email cannot be longer than 255 characters.'
        ],
        'password' => [
            'required' => 'You must enter your password.',
            'min_length' => 'Your password must be at least 8 characters.'
        ]
    ];

    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    /*
     * CREATE
     */

    public function create(Client $client): bool
    {
        try {
            if ($this->save($client)) {
                return true;
            } else {
                return false;
            }
        } catch (\ReflectionException $e) {
            log_message('error', '[ERROR] {exception}', ['exception' => $e]);
            return false;
        }
    }

    /*
     * READ
     */

    public function exists(Client $client): bool
    {
        if ($this->readByPhone($client)) {
            return true;
        } else {
            return false;
        }
    }

    public function readByPhone(Client $client)
    {
        // TODO: Show this in report.
        return $this
            ->select('id, first_name, last_name, title, phone, email')
            ->where('phone', $client->phone)
            ->first();
    }

    public function readByID(Client $client, bool $asArray = false)
    {
        if (!$asArray) {
            return $this
                ->select('id, first_name, last_name, title, phone, email, created_at')
                ->where('id', $client->id)
                ->first();
        } else {
            return $this
                ->asArray()
                ->select('id, first_name, last_name, title, phone, email, created_at')
                ->where('id', $client->id)
                ->first();
        }

    }

    /**
     * @param Client $client Client instance.
     * @return bool If the supplied credentials are correct.
     */
    public function login(Client $client): bool
    {
        $dbClient = $this
            ->select('password')
            ->where('phone', $client->phone)
            ->first();
        return password_verify($client->password, $dbClient->password);
    }


    /*
     * UPDATE
     */
    // TODO: Implement these methods.


    /*
     * DELETE
     */
    public function deleteByID(Client $client): bool
    {
        if ($this->delete($client->id)) {
            log_message('notice', 'User with id [{id}] deleted successfully.', ['id' => $client->id]);
            return true;
        } else {
            log_message('error', 'Deleting user with id [{id}] failed.', ['id' => $client->id]);
            return false;
        }
    }


    /*
     * MODEL FUNCTIONS
     */
    protected function hashPassword(array $data)
    {
        if (!isset($data['data']['password'])) return $data;

        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
        //unset($data['data']['password']);

        return $data;
    }

}
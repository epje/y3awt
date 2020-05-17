<?php


namespace App\Controllers;


class Form extends ParentController
{
    public function index()
    {
        helper(['form', 'url']);

        $rules = [
            'username' => 'required|min_length[4]'
        ];
        $messages = [
            'username' => [
                'required' => 'A username is required!',
                'min_length' => 'Your username must be at least 4 characters.'
            ]
        ];



        if (! $this->validate($rules, $messages))
        {
            echo view('Signup', [
                'validation' => $this->validator
            ]);
        }
        else
        {
            echo view('Success');
        }
    }

}
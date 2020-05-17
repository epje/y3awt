<?php namespace App\Controllers;

class Home extends ParentController
{
    public function index()
    {
        $keywords = [];
        $data = [
            'title' => 'Home',
            'description' => 'Homepage',
            'author' => '17003804',
            'copyright' => '17003804 &copy; 2020',
            'keywords' => $keywords,
            'user' => $this->session->get('clientID')
        ];



        echo view('templates/header', $data);
        echo view('home/index');
        echo view('templates/footer');
    }

    //--------------------------------------------------------------------

}

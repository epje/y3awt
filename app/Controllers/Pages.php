<?php namespace App\Controllers;


class Pages extends ParentController
{
    public function index()
    {
        $keywords = ['furniture', 'store', 'homepage', 'index'];
        $data = [
            'title' => 'Home',
            'description' => 'Homepage',
            'author' => '17003804',
            'copyright' => '17003804 &copy; 2020',
            'keywords' => $keywords
        ];
        $indexData = [
            'appName' => getenv('app.name')
        ];

        echo view('templates/header', $data);
        echo view('static/index', $indexData);
        echo view('templates/footer');
    }

    public function about()
    {
        $keywords = ['about', 'company information', 'employees'];
        $headerData = [
            'title' => 'About',
            'author' => '17003804',
            'description' => 'About ' . getenv('app.name'),
            'keywords' => $keywords,
            'copyright' => '17003804 &copy; 2020'
        ];
        $aboutData = [];

        echo view('templates/header', $headerData);
        echo view('static/about', $aboutData);
        echo view('templates/footer');
    }

    public function contact()
    {
        $keywords = ['contact', 'contact us', 'help', 'email'];
        $headerData = [
            'title' => 'Contact',
            'author' => '17003804',
            'description' => 'Contact ' . getenv('app.name'),
            'keywords' => $keywords,
            'copyright' => '17003804 &copy; 2020'
        ];
        $contactData = [];

        echo view('templates/header', $headerData);
        echo view('static/about', $contactData);
        echo view('templates/footer');
    }


}
<?php namespace App\Controllers;

use App\Models\ClientModel;

class Client extends ParentController
{
    protected string $loggedInURI = '/client/profile';

    public function index()
    {
        // If the request to login page is not secure, force it to be.
        if (!$this->request->isSecure()) {
            force_https();
        }

        // Check if the user is logged in.
        if (!$this->session->get('loggedIn')) {
            // If not, redirect to the login page and request login.
            return redirect()->to('/client/login')->with('phone', 'Please sign in first!');
        } else {
            // Otherwise redirect to their profile.
            return redirect()->to('client/profile');
        }
    }


    public function profile()
    {
        // If the request to profile page is not secure, force it to be.
        if (!$this->request->isSecure()) {
            force_https();
        }

        // Check if the client is logged in.
        if (!$this->session->get('loggedIn')) {
            // If not, redirect to the login page and request login.
            return redirect()->to('/client/login')->with('phone', 'Please sign in first!');
        }
            // Otherwise redirect to their profile.
            $keywords = ['client', 'login', 'login-page'];
            $data = [
                'author' => '17003804',
                'copyright' => '',
                'description' => 'Furniture Store Login Page',
                'title' => "Login",
                'keywords' => $keywords
                //'client.phone' => $this->session->get('client.phone')
            ];

            echo view('templates/header', $data);
            echo view('client/profile', $data);
            echo view('templates/footer', $data);

    }

    public function loginGet()
    {
        // If the request to login page is not secure, force it to be.
        if (!$this->request->isSecure()) {
            force_https();
        }

        // Check if the user is already logged in, if so, redirect.
        if ($this->session->get('loggedIn')) {
            return redirect()->to($this->loggedInURI);
        }

        $pageKeywords = ['client', 'login', 'login-page'];
        $data = [
            'author' => '17003804',
            'copyright' => '',
            'description' => 'Furniture Store Login Page',
            'title' => "Login",
            'keywords' => $pageKeywords,
            'validation' => $this->validator
            //'client.phone' => $this->session->get('client.phone')
        ];
        echo view('templates/header', $data);
        echo view('client/login', $data);
        return view('templates/footer');
    }

    public function loginPost()
    {
        // If the request to login page is not secure, force it to be.
        if (!$this->request->isSecure()) {
            force_https();
        }
        helper('form');

        // Check if the user is already logged in, if so, redirect.
        if ($this->session->get('loggedIn')) {
            return redirect()->to($this->loggedInURI);
        }

        $pageKeywords = ['client', 'login', 'login-page'];

        //if(!$this->validate([]))
        // TODOcomplete: why am I not using data? because you're not echoing views, just redirecting.
//        $data = [
//            'author' => '17003804',
//            'copyright' => '',
//            'description' => 'Furniture Store Login Page',
//            'title' => "Login",
//            'keywords' => $pageKeywords,
//            'validation' => $this->validator
//            //'client.phone' => $this->session->get('client.phone')
//        ];

        // If a form using POST was submitted.
        if ($this->request->getMethod() == 'post') {

            // Get the POST data and create new Client entity with it.
            $postData = $this->request->getPost();
            $client = new \App\Entities\Client($postData);

            // Create new ClientModel instance.
            $clientModel = new ClientModel();

            // Get the validation rules and messages from the model.
            // Because this is login, only the phone and password rules apply.
            $validationRules = $clientModel->getValidationRules(['only' => ['phone', 'password']]);
            $validationMessages = $clientModel->getValidationMessages();

            // Check if the input is valid, if not then show errors.
            // Only use the phone and password rules for the login page.
            if (!$this->validate($validationRules, $validationMessages)) {
                // Input validation failed.

                // If there was an error with the phone or password.
                if ($this->validator->hasError('phone') || $this->validator->hasError('password')) {
                    // Return the user to the login page with appropriate errors.
                    return redirect()
                        ->back()
                        ->with('phone', $this->validator->getError('phone'))
                        ->with('password', $this->validator->getError('password'))
                        ->withInput();
                }
            } else {
                // Input validation passed.
                if ($clientModel->exists($client)) {
                    // Client exists in the database (client.phone).
                    if ($clientModel->login($client)) {
                        // Correct credentials supplied.

                        // Get client information from the database.
                        $dbClient = $clientModel->readByPhone($client);

                        // Store their details in the session.
                        $this->session->set('clientID', $dbClient->id);

                        // Create log event of user login.
                        $logInfo = [
                            'user_id' => $dbClient->id,
                            'ip_address' => $this->request->getIPAddress()
                        ];
                        log_message('info', '[INFO] User [{user_id}] logged in from [{ip_address}].', $logInfo);

                        // Set logged in as true in session.
                        $this->session->set('loggedIn', true);

                        // Redirect to the relevant location.
                        return redirect()->to($this->loggedInURI);

                    } else {
                        // Incorrect credentials supplied.

                        // Create log of incorrect login attempt.
                        $logInfo = [
                            'ip_address' => $this->request->getIPAddress()
                        ];
                        log_message('notice', '[NOTICE] Failed login attempt with incorrect password from IP [{ip_address}].', $logInfo);

                        // Redirect back to the login page and set error on password field.
                        return redirect()->back()->with('password', 'Your password was incorrect!')->withInput();
                    }
                } else {
                    // Client does not exist in the database with provided phone number.

                    // Create log of incorrect login attempt.
                    $logInfo = [
                        'ip_address' => $this->request->getIPAddress()
                    ];
                    log_message('notice', '[NOTICE] Failed login attempt with non-existent phone number from IP [{ip_address}].', $logInfo);

                    // Redirect back to login page and set error on phone field.
                    return redirect()->back()->with('phone', 'Your account was not found!')->withInput();
                }
            }
        }
    }

    public function logout()
    {
        if ($this->session->get('loggedIn')) {
            $this->session->destroy();
            return redirect()->to('/')->with('message', 'You logged out successfully!');
        } else {
            return redirect()->to('/client/login')->with('phone', 'Please sign in first!');
        }
    }


    public function register()
    {
        if (!$this->request->isSecure()) {
            force_https();
        }

        // Check if the user is already logged in, if so, redirect.
        if ($this->session->get('loggedIn')) {
            return redirect()->to($this->loggedInURI);
        }

        // Only allow registration if it is enabled in the environment.
        if (!filter_var(getenv('app.registrationEnabled'), FILTER_VALIDATE_BOOLEAN)) {
            return redirect()->to('/');
        }

        $keywords = ['client', 'register', 'registration-page'];

        $data = [
            'author' => '17003804',
            'copyright' => 'aa',
            'description' => 'login',
            'title' => 'Register',
            'keywords' => $keywords
        ];

        $model = new ClientModel();

        // If a form using POST was submitted.
        if ($this->request->getMethod() == 'post') {

            // Create a new Client object from post data.
            $postData = $this->request->getPost();
            $client = new \App\Entities\Client($postData);

            try {
                if ($model->create($client)) {
                    // REGISTRATION SUCCEEDED.

                    // Retrieve the client information.
                    $dbClient = $model->readByPhone($client);

                    // Store a log message.
                    $logInfo = [
                        'id' => $dbClient->id
                    ];
                    log_message('info', '[INFO] User with id [{id}] registered successfully.', $logInfo);

                    return redirect()->to('/client/login')->with('message', 'Registered successfully!');

                } else {
                    // REGISTRATION FAILED.
                    // Store a log message.
                    $logInfo = [
                        'ip' => $this->request->getIPAddress()
                    ];
                    log_message('notice', '[NOTICE] Client registration failed from IP [{ip}].', $logInfo);

                    // Redirect back to the registration page.
                    return redirect()->back()->with('error', 'Account creation failed!')->withInput();
                }
            } catch (\Exception $e) {
                log_message('error', '[ERROR] {exception}', ['exception' => $e]);
            }
        } else {
            // TODO: Maybe use redirect instead of views.
            //return redirect()->to('/client/register');

            echo view('templates/header', $data);
            echo view('client/register');
            echo view('templates/footer');
        }
    }

    public function reset()
    {
        $this->auth();

        $data = [
            'title' => 'asda',
            'author' => 'auth',
            'description' => 'ad',
            'keywords' => [],
            'copyright' => 'aslkdj'
        ];
        echo view('templates/header', $data);
        echo view('client/reset');
        echo view('templates/footer');
    }


    /**
     * @return \CodeIgniter\HTTP\RedirectResponse
     * @todo Sort out how this is used in controller functions.
     */
    private function auth()
    {
        // If the request to login page is not secure, force it to be.
        if (!$this->request->isSecure()) {
            force_https();
        }

        // Check if the user is logged in.
        if (!$this->session->get('loggedIn')) {
            // If not, redirect to the login page and request login.
            return redirect()->to('/client/login')->with('phone', 'Please sign in first!');
        } else {
            // Otherwise redirect to their profile.
            return redirect()->to('client/profile');
        }

    }

    // TODO: REMOVE BEFORE PRODUCTION.
    public function delete($id)
    {
        $model = new ClientModel();
        $client = new \App\Entities\Client($id);

        $model->deleteByID($client);
    }

    // TODO: REMOVE BEFORE PRODUCTION.
    public function read($id, $num = 0)
    {
        $clientModel = new ClientModel();
        $client = new \App\Entities\Client(['id' => $id]);
        if (!$client = $clientModel->readByID($client)) {
            echo 'client does not exist or has been deleted.';
        } else {
            print('<pre>');
            print_r($client);
            print('</pre>');
        }
    }

}
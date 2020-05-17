<?php

namespace App\Controllers;

/**
 * Class ParentController
 *
 * ParentController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends ParentController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Session\Session;
use Config\Services;
use Psr\Log\LoggerInterface;

class ParentController extends Controller
{

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend ParentController.
     *
     * @var array
     */
    protected $helpers = ['cookie', 'text'];
    protected Session $session;

    /**
     * Constructor.
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param LoggerInterface $logger
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------

        // Make session and request variables available to every controller.
        $this->session = Services::session();
        $this->request = Services::request();

        //log_message('debug', '[DEBUG] User with ip [{ip}] connected with UserAgent [{ua}].', ['ip' => $request->getIPAddress(), 'ua' => $request->getUserAgent()]);

        // Old cookie-based cart idea.
//        if (!get_cookie('cart')){
//            $cookie = [
//                'name' => 'cart',
//                'value' => random_string('alnum',32),
//                'expire' => 86400
//            ];
//            set_cookie($cookie);
//        }
    }

}

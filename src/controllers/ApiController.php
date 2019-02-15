<?php
namespace App\Controllers;

use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\PhpRenderer;
use Monolog\Logger;

class ApiController {

    protected $version = 1.00;
    protected $view;
    protected $logger;

    /**
     * ApiController constructor.
     * @param PhpRenderer $view
     * @param Logger $logger
     */
    public function __construct(
      PhpRenderer $view,
      Logger $logger
    ) {
        $this->view = $view;
        $this->logger = $logger;
    }

    /**
     * @param $request
     * @param $response
     * @param $args
     */
    public function auth($request, $response, $args)
    {
    }

    /**
     * @param $request
     * @param $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function default($request, $response, $args)
    {
        $this->logger->info("Slim-Skeleton '/' route");

        return $this->view->render($response, 'default.phtml', $args);
    }

    /**
     * @param $request
     * @param $response
     * @param $args
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function login(Request $request, Response $response, $args)
    {
        $allGetVars = $request->getParams();
        if (isset($allGetVars['email']) && !filter_var($allGetVars['email'],FILTER_VALIDATE_EMAIL)) {
            $args['loginError'] = true;
        }
        return $this->view->render($response, 'login.phtml', $args);
    }

    /**
     * @param $request
     * @param $response
     * @return mixed
     */
    public function version($request, $response)
    {
        // use $this->view to render the HTML
        $body = $response->getBody();
        $body->write('v'. sprintf("%.02f", $this->version));

        return $response;
    }

}

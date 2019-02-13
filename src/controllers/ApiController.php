<?php
namespace App\Controllers;

use \Slim\Views\PhpRenderer;
use \Monolog\Logger;

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

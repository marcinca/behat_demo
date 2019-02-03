<?php
namespace App\Controllers;

use \Slim\Views\PhpRenderer;
use \Monolog\Logger;

class ApiController {

    protected $version = 1.0;
    protected $view;
    protected $logger;

    public function __construct(
      PhpRenderer $view,
      Logger $logger
    ) {
        $this->view = $view;
        $this->logger = $logger;
    }

    public function default($request, $response, $args)
    {
      $this->logger->info("Slim-Skeleton '/' route");

      return $this->view->render($response, 'default.phtml', $args);
    }

    public function version($request, $response, $args)
    {
      // use $this->view to render the HTML
      $body = $response->getBody();
      $body->write('v'. sprintf("%.02f", $this->version));

      return $response;
    }

}

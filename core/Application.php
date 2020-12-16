<?php

namespace app\core;

class Application {
  public static $ROOT_DIR;
  public Router $router;
  public Response $response;
  public Request $request;
  public static Application $application;

  public function __construct($rootPath) {
    self::$ROOT_DIR = $rootPath;
    self::$application = $this;
    //The application class has only one task, which is run the application, because of this the application need to have a a Application object just to access the response object to change the http status 
    $this->request = new Request();
    $this->response = new Response();
    $this->router = new Router($this->request, $this->response);
  }

  public function run() {
    echo $this->router->resolve();
  }
}

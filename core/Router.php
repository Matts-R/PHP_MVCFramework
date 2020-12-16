<?php

namespace app\core;

class Router {
  private Request $request;
  protected $routes = [[]];
  // It's a multidimensional array because one part will store the actions to GET method and other will store the actions to POST method and each of this will contain a path and each path will contain a callback function  
  public Response $response;

  public function __construct(Request $request, Response $response) {
    $this->request = $request;
    $this->response = $response;
  }

  public function get($path, $callback) {
    $this->routes['get'][$path] = $callback;
  }

  public function post($path, $callback) {
    $this->routes['post'][$path] = $callback;
  }

  public function resolve() {
    // This method just take the given path and executes his callback function   
    $path =  $this->request->getPath();
    $method = $this->request->getMethod();
    $callback = $this->routes[$method][$path] ?? false;

    if ($callback === false) {
      $this->response->setStatusCode(404);
      //Configuring the status of the request to 404 always that a requisition to a non mapping route is made 
      return $this->renderView('_404');
    }
    if (is_string($callback)) {
      // Assuming that if callback is a string, we will resolve it in a view

      return $this->renderView($callback);
    }
    if (is_array($callback)) {
      $callback = new $callback[0];
      // If it's an array, this means that the method to send data was POST and we need to create an object to be able to use this object to call render method from Controller class in class SiteController
    }

    return call_user_func($callback);
    // If the callback  it's a function, this method will execute it
  }

  public function renderView($view, $params = []) {
    $layoutContent = $this->getLayoutContent();
    $viewContent = $this->renderOnlyView($view, $params);

    return str_replace('{{content}}', $viewContent, $layoutContent);
  }

  protected function getLayoutContent() {
    ob_start();
    include_once Application::$ROOT_DIR . '/views/layouts/mainLayout.php';

    return ob_get_clean();
  }

  protected function renderOnlyView($view, $params) {
    foreach ($params as $key => $value) {
      $$key = $value;
      //The simbol $$ create a variable from "the name of the of the value"
      //This means, the value of $key is name, so this will create a variable named with the value of the value of $key variable
      //A varible named $name was crated from this operation
    }
    ob_start();
    include_once Application::$ROOT_DIR . "/views/$view.php";

    return ob_get_clean();
  }
}

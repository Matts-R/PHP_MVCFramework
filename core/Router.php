<?php

namespace app\core;

class Router {
  private Request $request;
  protected $routes = [[]];
  // It's a multidimensional array because one part will store the actions to GET method and other will store the actions to POST method and each of this will contain a path and each path will contain a callback function  

  public function __construct(Request $request) {
    $this->request = $request;
  }

  public function get($path, $callback) {
    $this->routes['get'][$path] = $callback;
  }

  public function resolve() {
    // This method just take the given path and executes his callback function   
    $path =  $this->request->getPath();
    $method = $this->request->getMethod();
    $callback = $this->routes[$method][$path] ?? false;

    if ($callback === false) {

      return 'None action were found to this address';
    }
    if (is_string($callback)) {
      // Assuming that if callback is a string, we will resolve it in a view

      return $this->renderView($callback);
    }

    return call_user_func($callback);
  }

  public function renderView($view) {
    $layoutContent = $this->getLayoutContent();
    $viewContent = $this->getView($view);

    return str_replace('{{content}}', $viewContent, $layoutContent);
  }

  protected function getLayoutContent() {
    ob_start();
    include_once Application::$ROOT_DIR . '/views/layouts/mainLayout.php';

    return ob_get_clean();
  }

  protected function getView($view) {
    ob_start();
    include_once Application::$ROOT_DIR . "/views/$view.php";

    return ob_get_clean();
  }
}

<?php

use app\core\Application;

class Controller {
  public function render($view, $params = []) {
    Application::$application->router->renderView($view, $params);
  }
}

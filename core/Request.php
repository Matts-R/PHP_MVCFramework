<?php

namespace app\core;

class Request {

  public function getPath() {
    // This method will get the value from REQUEST_URI from super global SERVER and then will search for the string without any parameter to get the right given path

    $path = $_SERVER['REQUEST_URI'] ?? '/';
    // If REQUEST_URI exits and its value is not null, his value will be assigned to the variable $path

    $position = strpos($path, '?');
    if ($position === false) {

      return $path;
    }

    return substr($path, 0, $position);
  }



  public function getMethod() {
    return strtolower($_SERVER['REQUEST_METHOD']);
  }
}

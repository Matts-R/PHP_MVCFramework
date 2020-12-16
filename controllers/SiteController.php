<?php

namespace app\controllers;

use app\core\Application;
use Controller;

class SiteController extends Controller {
  public function home() {
    $params = ['name' => "Matheus"];
    return $this->render('home', $params);
    // It's not possible to use $this in this context because no SiteController instance is created 
    // This is resolved in resolve method of Router class
  }

  public function contact() {
    return $this->render('contact');
  }

  public function handleContact() {
    return 'Handling submitted data';
  }
}

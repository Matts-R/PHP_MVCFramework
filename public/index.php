  <?php
  require_once __DIR__ . '/../vendor/autoload.php';

  use app\controllers\SiteController;
  use \app\core\Application;

  $application = new Application(dirname(__DIR__));

  $application->router->get('/', [SiteController::class, 'home']);
  $application->router->get('/contact', [SiteController::class, 'contact']);
  // $application->router->post('/contact', 'contact');

  $application->router->post('/contact', [SiteController::class, 'handleContact']);
  // This array passed as an argument wont fall in the is_string if because it's an array, the ::class returns the name of the class and the next item is the name of some function from the class, this will cause this function to be executed 

  $application->run();

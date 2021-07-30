
<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../../vendor/autoload.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];
if($method == "OPTIONS") {
    die();
}

$auxContainer = new \DI\Container();
AppFactory::setContainer($auxContainer);
$app = AppFactory::create();
$app->setBasePath('/curso-angular_backend/public');
$app->addBodyParsingMiddleware(); //---metodo put funcione el request getParsedBody
$container=$app->getContainer();

require __DIR__ . '/Routes.php';
require __DIR__ . '/Configs.php';
require __DIR__ . '/Dependencies.php';

$app->run();

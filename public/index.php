<?php
use DI\Container;
use Jenssegers\Blade\Blade;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Illuminate\Database\Capsule\Manager;
use models\User;

require __DIR__ . '/../vendor/autoload.php';
$settings = require __DIR__ . '/../config/settings.php';

// Create Container using PHP-DI
$container = new Container();

// Set container to create App with on AppFactory
AppFactory::setContainer($container);

$cache = __DIR__ . '/../cache';
$views = __DIR__ . '/../views';

$blade = new Blade($views, $cache);

$app = AppFactory::create();

// Add Error Handling Middleware
$app->addErrorMiddleware(true, false, false);

// Add Eloquent ORM
$capsule = new Manager;
$capsule->addConnection($settings['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();
$users = User::All();



$app->get('/', function (Request $request, Response $response, $args) use($blade, $users) {
    $body = $blade->make('home', compact('users'))->render();
    $response->getBody()->write($body);
    return $response;
});

$app->get('/about', function (Request $request, Response $response, $args) use($blade) {
    $body = $blade->make('about')->render();
    $response->getBody()->write($body);
    return $response;
});

$app->run();
//var_dump($users); exit;

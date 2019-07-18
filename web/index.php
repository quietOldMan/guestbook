<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bootstrap.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;
use Symfony\Component\HttpKernel\Controller;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

error_reporting(E_ALL);
ini_set('display_errors', 1);

$logger = new Logger('web_log');
$logger->pushHandler(new StreamHandler('web.log', Logger::DEBUG));

$guestbookRoute = new Route(
    '/view',  // path
    array('_controller' => 'Guestbook\Controller\DefaultController::view') // default values
);

//    // Init route with dynamic placeholders
//    $guestbookPageRoute = new Route(
//        '/{id}',
//        array('controller' => 'FooController', 'method'=>'load'),
//        array('id' => '[0-9]+')
//    );

$routes = new RouteCollection();
$routes->add('guestbook', $guestbookRoute);

$context = new RequestContext();

$request = Request::createFromGlobals();
$context->fromRequest($request);

$logger->debug(sprintf('New Request processing. PATH: [%s] QUERY: [%s]', $context->getPathInfo(), $context->getQueryString()));

$matcher = new UrlMatcher($routes, $context);

try {
    $request->attributes->add($matcher->match($request->getPathInfo()));
    $request->attributes->add(['em' => $entityManager]);
    $request->attributes->add(['logger' => $logger]);

    $controllerResolver = new Controller\ControllerResolver();
    $argumentResolver = new Controller\ArgumentResolver();

    $controller = $controllerResolver->getController($request);
    $arguments = $argumentResolver->getArguments($request, $controller);

    $response = new Response(call_user_func_array($controller, $arguments),Response::HTTP_OK);
} catch (ResourceNotFoundException $e) {
    $response = new Response('Not Found!', Response::HTTP_NOT_FOUND);
} catch (Exception $exception) {
    $logger->error(sprintf('Exception on route processing. Message: %s', $exception->getMessage()));
    $response = new Response('An error occurred', 500);
}

$response->send();
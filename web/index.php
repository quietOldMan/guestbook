<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bootstrap.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
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

$session = new Session();
$session->start();

$logger = new Logger('web_log');
$logger->pushHandler(new StreamHandler('web.log', Logger::DEBUG));

$guestbookRoute = new Route(
    '/',  // path
    array('_controller' => 'Guestbook\Controller\DefaultController::indexAction') // default values
);

$guestbookTableRoute = new Route(
    '/view/{page}',  // path
    array('_controller' => 'Guestbook\Controller\DefaultController::loadTableAction', 'page' => 0), // default values
    array('page' => '[0-9]+') // requirements
);

$captchaRoute = new Route(
    '/captcha',  // path
    array('_controller' => 'Guestbook\Controller\DefaultController::createCaptchaAction', 'page' => 0) // default values
);

$routes = new RouteCollection();
$routes->add('guestbook', $guestbookRoute);
$routes->add('table', $guestbookTableRoute);
$routes->add('captcha', $captchaRoute);

$context = new RequestContext();

$request = Request::createFromGlobals();
$context->fromRequest($request);

$logger->debug(sprintf('New Request processing. PATH: [%s] QUERY: [%s]', $context->getPathInfo(), $context->getQueryString()));

$matcher = new UrlMatcher($routes, $context);

try {
    $attributes = $matcher->match($request->getPathInfo());
    $request->attributes->add($attributes);

    if ($attributes['_route'] === 'table') {
        $request->attributes->add(['em' => $entityManager]);
        $request->attributes->add(['logger' => $logger]);
    } else {
        $captcha_seed = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
        $captcha = substr(str_shuffle($captcha_seed), 0, 6);
        $request->attributes->add(['captcha' => $captcha]);
    }

    $controllerResolver = new Controller\ControllerResolver();
    $argumentResolver = new Controller\ArgumentResolver();

    $controller = $controllerResolver->getController($request);
    $arguments = $argumentResolver->getArguments($request, $controller);

    call_user_func_array($controller, $arguments);
} catch (ResourceNotFoundException $e) {
    $response = new Response('Not Found!', Response::HTTP_NOT_FOUND);
} catch (Exception $exception) {
    $logger->error(sprintf('Exception on route processing. Message: %s', $exception->getMessage()));
    $response = new Response('An error occurred', Response::HTTP_INTERNAL_SERVER_ERROR);
}
<?php
ini_set('display_errors', '2');
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../config/config.php';

$request = Request::createFromGlobals();

$context = new RequestContext();
$context->fromRequest(Request::createFromGlobals());

$matcher = new UrlMatcher($routes, $context);
$parameters = $matcher->match($request->getPathInfo());

$controller = new $parameters['controller']($database, $request);
$action = $parameters['action'];
unset($parameters['_route'], $parameters['controller'], $parameters['action']);

$data = call_user_func_array([$controller, $action], $parameters);
$response = new JsonResponse($data);

$response->send();
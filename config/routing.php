<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();

$routes->add('find_all', new Route('/{table_name}', [
        'controller'    => 'HBD\\Controller\\Controller',
        'action'        => 'findAll'
    ], [], [], '', [], ['GET']) );
$routes->add('find', new Route('/{table_name}/{id}', [
    'controller'    => 'HBD\\Controller\\Controller',
    'action'        => 'find'
], [], [], '', [], ['GET']) );
$routes->add('post', new Route('/{table_name}', [
    'controller'    => 'HBD\\Controller\\Controller',
    'action'        => 'post'
], [], [], '', [], ['POST']) );
$routes->add('put', new Route('/{table_name}/{id}', [
    'controller'    => 'HBD\\Controller\\Controller',
    'action'        => 'put'
], [], [], '', [], ['POST', 'PUT']) );
$routes->add('delete', new Route('/{table_name}/{id}', [
    'controller'    => 'HBD\\Controller\\Controller',
    'action'        => 'delete'
], [], [], '', [], ['DELETE']) );
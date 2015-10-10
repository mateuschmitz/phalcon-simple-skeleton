<?php

/**
 * <description>
 * 
 * @author  Mateus Schmitz <matteuschmitz@gmail.com>
 * @license MIT License
 * @package Config
 * @version alpha
 */

namespace Config;

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Router\Group as RouterGroup;

$router = new Router();
$router->removeExtraSlashes(true);

$api = new RouterGroup(
    array(
        'namespace'  => 'Application\\Controller',
        'controller' => 'index',
        'action'     => 'index'
    )
);

// $api->setPrefix('/');

$api->add('')->via(array('GET'));
$api->add('/:controller', array('controller' => 1))->via(array('GET'));
$api->add('/:controller/:action', array(
        'controller' => 1,
        'action'     => 2
    )
)->via(array('GET'));
$api->add('/:controller/:int', array(
        'controller' => 1,
        'id'         => 2
    )
)->via(array('GET'));
$api->add('/:controller/:int/:action', array(
        'controller' => 1,
        'action'     => 3,
        'id'         => 2
    )
)->via(array('GET'));

$router->mount($api);
return $router;
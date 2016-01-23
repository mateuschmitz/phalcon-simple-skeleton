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

$router->setDefaults(
    array(
        'namespace'  => 'Application\Controller',
        'controller' => 'index',
        'action'     => 'index'
    )
);

$router->add('/')->via(array('GET'));
$router->add('/:controller', array('controller' => 1))->via(array('GET'));
$router->add('/:controller/:action', array('controller' => 1, 'action' => 2))->via(array('GET'));
$router->add('/:action', array('action' => 1))->via(array('GET'));

return $router;
<?php

/**
 * <description>
 * 
 * @author  Mateus Schmitz <matteuschmitz@gmail.com>
 * @license MIT License
 * @package Config
 * @version alpha
 */

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Router\Group as RouterGroup;

$router = new Router();
$router->removeExtraSlashes(true);

$router->setDefaultNamespace('Application\Controller');

return $router;

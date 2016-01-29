<?php

/**
 * <description>
 * 
 * @author  Mateus Schmitz <matteuschmitz@gmail.com>
 * @license MIT License
 * @package Bootstrap
 * @version alpha
 */

chdir(dirname(__DIR__));

define('DS', DIRECTORY_SEPARATOR);

require('bootstrap.php');
require('./vendor/autoload.php');

$whoops = new Whoops\Run();
$whoops->pushHandler(new Whoops\Handler\PrettyPageHandler());
$whoops->register();

Bootstrap\Bootstrap::startApplication();

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

try {
    Bootstrap\Bootstrap::startApplication();
} catch (\Exception $e) {
    echo "PhalconException: ", $e->getMessage();
}
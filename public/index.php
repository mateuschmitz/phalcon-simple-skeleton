<?php

/**
 * <description>
 * 
 * @author  Mateus Schmitz <matteuschmitz@gmail.com>
 * @license MIT License
 * @package Application
 * @version alpha
 */

chdir(dirname(__DIR__));

define('DS', DIRECTORY_SEPARATOR);

require('bootstrap.php');

try {
    Bootstrap::startApplication();
    // var_dump(Bootstrap::getConfig());
} catch (\Exception $e) {
    echo "PhalconException: ", $e->getMessage();
}
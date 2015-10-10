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

use Phalcon\Loader;

$loader = new Loader();
$loader->registerNamespaces(
    array(
        "Application" => "./src/",
    )
);

$loader->register();

return $loader;
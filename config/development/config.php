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

defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));

return array(
    'php_config'       => array(
        'error_reporting' => E_ALL
    ),
    // 'databases' => array(
    //     'db' => array(
    //         "adapter"  => "Phalcon\Db\Adapter\Pdo\Mysql", // optional if MySQL Adapter
    //         "host"     => "HOST_MYSQL",
    //         "username" => "USERNAME",
    //         "password" => "PASSWORD",
    //         "dbname"   => "DBNAME",
    //         "options"  => array(
    //             PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
    //         )
    //     )
    // ),
);

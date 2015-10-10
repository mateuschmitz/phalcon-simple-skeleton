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

use Phalcon\Mvc\View;

return array(
    'php-config'       => array(
        'date_default_timezone_set' => 'America/Sao_Paulo',
        'header'                    => array(
            "Access-Control-Allow-Origin: *", 
            'Access-Control-Allow-Methods: GET, POST, PUT, DELETE',
        )
    ),
    'databases' => array(),
    'services'  => array(
		'view'   => function () {
            $view = new View();
            $view->setViewsDir('./View/');
            $view->disableLevel(array(View::LEVEL_MAIN_LAYOUT => false));
            return $view;
		},
		'router' => function () {
    		return require __DIR__ . "/config.routes.php";
		}
	)
);
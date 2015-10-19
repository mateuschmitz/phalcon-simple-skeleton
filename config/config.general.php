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
    'php_config'       => array(
        'date_default_timezone_set' => 'America/Sao_Paulo',
        // 'header'                    => array(
        //     "Access-Control-Allow-Origin: *",
        //     'Access-Control-Allow-Methods: GET, POST, PUT, DELETE',
        // )
    ),
    'databases' => array(),
    'services'  => array(
		'view'   => function () {
            $view = new View();
            $view->disableLevel(
                array(
                    View::LEVEL_MAIN_LAYOUT => true
                )
            );

            $view->setViewsDir('./src/View/view/');
            $view->setLayoutsDir('../layout/');
            $view->setPartialsDir('../partial/');
            $view->setLayout('default');
            
            return $view;
		},
		'router' => function () {
    		return require __DIR__ . "/config.routes.php";
		}
	)
);
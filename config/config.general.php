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

use PDO,
    Phalcon\Mvc\View,
    Phalcon\Events\Manager,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Flash\Session as FlashSession,
    Phalcon\Mvc\View\Engine\Php as PhpEngine,
    Phalcon\Mvc\View\Engine\Volt;

defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../'));

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

            $view->registerEngines([
                '.volt' => function ($view) {
                    $volt = new Volt($view, $this);

                    $volt->setOptions([
                        'compiledPath' => BASE_PATH . '/cache/',
                        'compiledSeparator' => '_'
                    ]);

                    return $volt;
                },
                '.phtml' => PhpEngine::class
            ]);

            return $view;
		},
        'session' => function(){
		    $session = new \Phalcon\Session\Adapter\Files();
		    $session->start();
		    return $session;
        },
        'flashSession' => function() {
            $flash = new FlashSession(
                array(
                    'error'   => 'alert alert-danger',
                    'success' => 'alert alert-success',
                    'notice'  => 'alert alert-info',
                    'warning' => 'alert alert-warning'
                )
            );

            $flash->setAutoescape(false);

            return $flash;
        },
		'router' => function () {
    		return require __DIR__ . "/config.routes.php";
		},
        'dispatcher' => function() {
            $eventsManager = new Manager();
            $dispatcher = new Dispatcher();
            $dispatcher->setEventsManager($eventsManager);
            return $dispatcher;
        }
	)
);

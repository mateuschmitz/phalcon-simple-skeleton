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
    'databases' => array(),
    'services'  => array(
		// 'view'   => function () {
  //   		$view = new View();
  //   		$view->disableLevel(array(View::LEVEL_NO_RENDER => true));
  //   		return $view;
		// },
		'router' => function () {
    		return require __DIR__ . "/config.routes.php";
		}
	)
);
<?php

/**
 * <description>
 * 
 * @author  Mateus Schmitz <matteuschmitz@gmail.com>
 * @license MIT License
 * @package Bootstrap
 * @version alpha
 */

use Phalcon\Mvc\Application,
    Phalcon\DI\FactoryDefault,
    Phalcon\Config;

class Bootstrap
{
    private static function getResource($filename, $env = null)
    {
        $path = (is_null($env)) ? 'config' : 'config' . DS . $env;
        return (is_readable($path . DS . $filename . '.php')) ? require($path . DS . $filename . '.php') : null;
    }

    private static function getConfig($env = null)
    {
        $env = (is_null($env)) ? self::getEnv() : $env;

        $configFiles = array(
            'config.general.php',
            $env . DS . 'config.php',
            'config.local.php'
        );
        
        $config = array();
        foreach ($configFiles as $file) {
            if (is_readable('config' . DS . $file)) {
                $config = array_merge_recursive($config, require('config' . DS . $file));
            }
        }
        
        return new Config($config);
    }

    private static function getEnv()
    {
        return (isset($_SERVER['APPLICATION_ENV'])) ? $_SERVER['APPLICATION_ENV'] : 'production';
    }

    private static function configureApplication(Config $settings)
    {
        $di = new FactoryDefault();

        // set services
        foreach ($settings->services as $service => $content) {
            $di->set($service, $content);
        }

        // set connections
        foreach ($settings->databases as $database => $content) {

            $adapter = isset($content['adapter']) ? $content['adapter'] : "Phalcon\Db\Adapter\Pdo\Mysql";
            unset($content['adapter']);

            $di->set($database, function () use ($adapter, $content){
                return new $adapter(
                    $content->toArray()
                );
            });
        }
       
        return $di;
    }

    public static function startApplication($env = null)
    {
        $loader = self::getResource('config.loader');
        $config = self::getConfig($env);

        $application = new Application(self::configureApplication($config));
        echo $application->handle()->getContent();
    }
}
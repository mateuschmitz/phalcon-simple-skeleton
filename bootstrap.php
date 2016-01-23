<?php

/**
 * <description>
 * 
 * @author  Mateus Schmitz <matteuschmitz@gmail.com>
 * @license MIT License
 * @package Bootstrap
 * @version alpha
 */
namespace Bootstrap;

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

    public static function getConfig($env = null)
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
        // set php config
        foreach ($settings->php_config as $function => $param) {
            self::configurePHP($function, $param);
        }

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

    private static function configurePHP($function, $params)
    {
        if (!$params instanceof \Phalcon\Config) {
            return $function($params);
        }

        foreach ($params as $param) {
            self::configurePHP($function, $param);
        }
    }

    public static function log($content)
    {
        $file = fopen('./logs/log_file_custom.log', 'a+');
        fwrite($file, date('Y-m-d H:i:s') . "\t" . memory_get_peak_usage(true) .  "\t{$content}\n");
    }

    public static function startApplication($env = null)
    {
        $loader = self::getResource('config.loader');
        $config = self::getConfig($env);

        $application = new Application(self::configureApplication($config));
        echo $application->handle()->getContent();
    }
}
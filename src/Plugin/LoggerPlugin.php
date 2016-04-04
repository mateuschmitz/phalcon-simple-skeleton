<?php

/**
 * <description>
 * 
 * @author  Mateus Schmitz <matteuschmitz@gmail.com>
 * @license MIT License
 * @package Application\Plugin
 * @version alpha
 */

namespace Application\Plugin;

use Phalcon\Events\Event,
    Phalcon\Mvc\User\Plugin,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Logger,
    Phalcon\Logger\Adapter\File as FileAdapter,
    Bootstrap\Bootstrap;

class LoggerPlugin extends Plugin
{
    /**
     * @var Phalcon\Config
     */
    private $config;

    /**
     * class construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->config = Bootstrap::getConfig();
    }

    /**
     * Triggered after entering in the dispatch loop. At this point the dispatcher don’t know if the controller
     * or the actions to be executed exist. The Dispatcher only knows the information passed by the Router.
     *
     * Can stop operation: yes
     *
     * @param  Event      $event
     * @param  Dispatcher $dispatcher
     * @return boolean
     */
    public function beforeDispatch(Event $event, Dispatcher $dispatcher)
    {
        $request  = $dispatcher->getDi()->get('request');
        $response = $dispatcher->getDi()->get('response');
        $url      = $this->getUrl($request);

        /**
         * Prevents to log JS/CSS requests
         */
        if (!$this->isLogable($url)) {
            return true;
        }

        $message = "{$request->getClientAddress()}";
        $message .= (!empty($_COOKIE['PHPSESSID'])) ? " | {$_COOKIE['PHPSESSID']}": " | ~" ;
        $message .= " | {$request->getMethod()} | {$url} {$request->getServer('SERVER_PROTOCOL')}";
        $message .= ($request->getMethod() === 'POST') ? ' | (POSTDATA: ' . json_encode($request->getPost()) . ')' : '';
        $message .= ($request->getMethod() === 'PUT') ? ' | (PUTDATA: ' . json_encode($request->getPut()) . ')' : '';
        $message .= " | UA {$request->getUserAgent()}";

        $logger = new FileAdapter("./logs/" . date('Ymd') . ".log");
        $formatter = new \Phalcon\Logger\Formatter\Line("%date% | %type% | %message%");
        $formatter->setDateFormat('c');
        $logger->setFormatter($formatter);
        $logger->debug($message);
    }

    /**
     * Returns URL requested
     * 
     * @param  \Phalcon\Http\Request $request
     * @return string
     */
    private function getUrl(\Phalcon\Http\Request $request)
    {
        $scheme = $request->getServer('REQUEST_SCHEME');
        $host   = $request->getServer('HTTP_HOST');
        $uri    = $request->getServer('REQUEST_URI');

        return "{$scheme}://{$host}{$uri}";
    }

    /**
     * Verify if executed request is for JS, Fonts and CSS files. Case yes
     * returns false. Case not returns true.
     * 
     * @param  string  $url
     * @return boolean
     */
    private function isLogable($url)
    {
        preg_match('/(\.css|\.woff2|\.js)$/', $url, $m);
        return (empty($m)) ? true : false;
    }
}

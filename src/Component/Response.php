<?php

/**
 * <description>
 * 
 * @author  Mateus Schmitz <matteuschmitz@gmail.com>
 * @license MIT License
 * @package Application\Component
 * @version alpha
 */

namespace Application\Component;

class Response extends \Phalcon\Http\Response
{
    const CODE_OK                    = 200;
    const CODE_CREATED               = 201;
    const CODE_BAD_REQUEST           = 400;
    const CODE_FORBIDDEN             = 403;
    const CODE_NOT_FOUND             = 404;
    const CODE_METHOD_NOT_ALLOWED    = 405;
    const CODE_CONFLICT              = 409;
    const CODE_INTERNAL_SERVER_ERROR = 500;
    const CODE_NOT_IMPLEMENTED       = 501;
    const CODE_SERVICE_UNAVAILABLE   = 503;

    const MESSAGE_OK                    = "OK";
    const MESSAGE_CREATED               = "Created";
    const MESSAGE_BAD_REQUEST           = "Bad Request";
    const MESSAGE_FORBIDDEN             = "Forbidden";
    const MESSAGE_NOT_FOUND             = "Not Found";
    const MESSAGE_METHOD_NOT_ALLOWED    = "Method Not Allowed";
    const MESSAGE_CONFLICT              = "Conflict";
    const MESSAGE_INTERNAL_SERVER_ERROR = "Internal Server Error";
    const MESSAGE_NOT_IMPLEMENTED       = "Not Implemented";
    const MESSAGE_SERVICE_UNAVAILABLE   = "Service Unavailable";

    /**
     * class constructor
     * Set content-type and default content of response
     *
     * @return void
     */
    public function __construct()
    {
        $this->setContentType('application/json');
        $this->setJsonContent(array());
    }

    /**
     * Método mágico _call
     * Chamado caso o método invocado não exista. Verifica se o que foi chamado
     * foi um envio de resposta para o cliente. Caso seja, verifica qual mensagem
     * foi solicitada e a envia
     * 
     * @param  string $name      método chamado
     * @param  array  $arguments parâmetros passados ao método
     * @throws BadMethodCallException caso o método não esteja previsto ou não deva existir
     * @return Api\Component\response
     */
    public function __call($name, $arguments)
    {
        $prefix = substr($name, 0, 4);
        if ($prefix === 'send') {

            $method  = substr($name, 4, strlen($name));
            $method  = preg_split('/(?=[A-Z])/', lcfirst($method));
            $code    = 'CODE_';
            $message = 'MESSAGE_';

            foreach ($method as $key => $value) {
                if ($key !== 0) {
                    $code    .= "_";
                    $message .= "_";
                }
                $code    .= strtoupper($value);
                $message .= strtoupper($value);
            }

            if (defined('self::' . $code)) {
                $this->setStatusCode(constant('self::' . $code), constant('self::' . $message));
                $this->setJsonContent(array('count' => 0, 'data' => array()));
                
                if (isset($arguments[0])) {
                    $content = (isset($arguments[1]) && $arguments[1] === true)
                        ? $arguments[0]
                        : array('count' => count($arguments[0]), 'data' => $arguments[0]);

                    $this->setJsonContent($content);
                }
                return $this;
            }
        }

        throw new \BadMethodCallException("Método $name não definido");
    }
}
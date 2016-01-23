<?php

/**
 * <description>
 * 
 * @author  Mateus Schmitz <matteuschmitz@gmail.com>
 * @license MIT License
 * @package Application\Controller
 * @version alpha
 */

namespace Application\Controller;

class BaseController extends \Phalcon\Mvc\Controller
{
    public function initialize()
    {
        $this->view->setTemplateAfter('default');
    }
}

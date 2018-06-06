<?php

/**
 * <description>
 * 
 * @author  Mateus Schmitz <matteuschmitz@gmail.com>
 * @license MIT License
 * @package Application\Model
 * @version alpha
 */

namespace Application\Model;

use Phalcon\Mvc\Model\Transaction\Manager as TransactionManager;

class BaseModel extends \Phalcon\Mvc\Model
{
    /**
     * Initialize BaseModel and sets database used in queries
     * 
     * @return void
     */
    public function initialize()
    {
        $this->setConnectionService('db');
    }

    /**
     * Returns a new transaction to be used in updates and
     * deletes SQL.
     * 
     * @return Phalcon\Mvc\Model\Transaction\Manager
     */
    protected function getNewTransaction()
    {
        $manager = new TransactionManager();
        $manager->setDbService('db');
        return $manager->get();
    }

}

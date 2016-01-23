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

    /**
     * Acts as setters and getters for all properties.
     * 
     * @param string $name Function name: setSomething or getSomething.
     * @param array $arguments The position 0 of this array will be used as value to setSomething.
     * @return mixed
     */
    public function __call($name, $arguments = null)
    {
        $class = get_called_class();
        $action = substr($name, 0, 3);

        switch ($action) {
            case 'get':
                $property = substr($name, 3);

                if (property_exists($class, $property)) {
                    return $this->{$property};
                }

                $property[0] = strtolower($property[0]);
                if (!property_exists($class, $property)) {
                    return parent::__call($name, $arguments);
                }

                return $this->{$property};

            case 'set':
                $property = substr($name, 3);
                $property[0] = strtolower($property[0]);
                if (!property_exists($class, $property)) {
                    return parent::__call($name, $arguments);
                }
                $this->{$property} = $arguments[0];
                return $this;

            default:
                return parent::__call($name, $arguments);
        }
    }
}

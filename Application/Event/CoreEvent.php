<?php

namespace Application\Event;

use Application\Base\Option;

use Symfony\Component\EventDispatcher\Event as sfEvent;

/**
 *
 *
 * @author chente
 *
 */
class CoreEvent extends sfEvent
{

    const BOOTSTRAP_INIT_CONTAINER = 'bootstrap.init_container';
    const BOOTSTRAP_INIT_VIEW = 'bootstrap.init_view';
    const BOOTSTRAP_INIT_CONFIG = 'bootstrap.init_config';
    const BOOTSTRAP_INIT_DATABASE = 'bootstrap.init_database';
    const BOOTSTRAP_REGISTER_CORE_LISTENER = 'bootstrap.register_core_listener';

    /**
     *
     *
     * @var array
     */
    protected $parameters = array();

    /**
     *
     * @param array $array
     */
    public function __construct($parameters = array() )
    {
        if( !is_array($parameters) )
            throw new \Exception("Parameters no permitidos");

        foreach ($parameters as $parameter => $value){
            $this->set($parameter, $value);
        }
    }

    /**
     *
     *
     * @param string $parameter
     * @param mixed $value
     */
    public function set($parameter, $value){
        $this->parameters[$parameter] = $value;
    }

    /**
     *
     *
     * @param string $paremeter
     * @param mixed $default
     * @return mixed
     */
    public function get($parameter, $default = null){
        return isset($this->parameters[$parameter]) ? $this->parameters[$parameter] : $default;
    }

    /**
     *
     * @param string $parameter
     * @param string $message
     * @return mixed
     */
    public function getOrThrow($parameter, $message){
        return $this->getOption($parameter)->getOrThrow($message);
    }

    /**
     *
     * @param string $parameter
     * @return \Application\Base\Option
     */
    public function getOption($parameter){
        return new Option($this->get($parameter));
    }

    /**
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

}
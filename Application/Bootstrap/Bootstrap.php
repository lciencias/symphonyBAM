<?php

namespace Application\Bootstrap;

use Application\Event\CoreListener;
use Application\Event\CoreEvent;
use Application\Database\DBAO;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\Config\FileLocator;

/**
 *
 * @author chente
 *
 */
class Bootstrap extends \Zend_Application_Bootstrap_Bootstrap
{

    /**
     *
     * @var \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    private $container;

    /**
     *
     * @var \Zend_Registry
     */
    private $registry;

    /**
     * @return \Zend_Registry
     */
    protected function getRegistry(){
        if( null == $this->registry ){
            $this->registry = new \Zend_Registry(array(), \ArrayObject::ARRAY_AS_PROPS);
            \Zend_Registry::setInstance($this->registry);
        }
        return $this->registry;
    }

    /**
     * @return \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    protected function initContainer()
    {
        $this->container = new ContainerBuilder();
        $loader = new XmlFileLoader($this->container, new FileLocator(realpath('.')));
        $loader->load('data/Services.xml');

        $this->initEventDispatcher();

        $this->getRegistry()->set('container', $this->container);
        $this->getEventDispatcher()->dispatch(CoreEvent::BOOTSTRAP_INIT_CONTAINER, new CoreEvent(array(
            'container' => $this->container,
        )));

        return $this->container;
    }

    /**
     *
     */
    protected function initEventDispatcher(){
        $eventDispacther = $this->getEventDispatcher();
        $eventDispacther->addSubscriber(new CoreListener());
        $eventDispacther->dispatch(CoreEvent::BOOTSTRAP_REGISTER_CORE_LISTENER, new CoreEvent(array(
                'eventDispatcher' => $eventDispacther,
        )));
    }

    /**
     * @return \Application\Smarty\ZendSmarty
     */
    protected function initView()
    {
        $view = $this->getDICContainer()->get('zend_smarty');
        $view->getEngine()->setZendView($view);
        $viewHelper = new \Zend_Controller_Action_Helper_ViewRenderer($view);
        $viewHelper->setViewSuffix('tpl');
        \Zend_Controller_Action_HelperBroker::addHelper($viewHelper);

        $this->getEventDispatcher()->dispatch(CoreEvent::BOOTSTRAP_INIT_VIEW, new CoreEvent(array(
            'view' => $view,
        )));

        return $view;
    }

    /**
     * @return \Zend_Config_Xml
     */
    protected function initConfig()
    {
        $config = $this->getDICContainer()->get('webconfig');

        $this->getRegistry()->set('config', $config);

        $this->getEventDispatcher()->dispatch(CoreEvent::BOOTSTRAP_INIT_CONFIG, new CoreEvent(array(
            'config' => $config,
        )));

        return $config;
    }

    /**
     *
     */
    protected function initConfigureDatabase()
    {
        $dbao = $this->getDICContainer()->get('dbao');
        if( (bool) $this->getRegistry()->config->database->params->profiler )
        {
            $profiler = new \Zend_Db_Profiler_Firebug('Databases queries');
            $profiler->setEnabled(true);
            $dbao->getDbAdapter()->setProfiler($profiler);
        }

        $this->getEventDispatcher()->dispatch(CoreEvent::BOOTSTRAP_INIT_DATABASE, new CoreEvent(array(
            'dbAdapter' => $dbao,
        )));
    }
    /**
     * @return \Zend_Controller_Front
     */
    protected function initFrontController(){
        $front = \Zend_Controller_Front::getInstance();
        $front->setControllerDirectory('controllers/');
        $front->setParam('noViewRenderer', false);
        $front->throwExceptions(false);
        return $front;
    }

    /**
     * @return \Zend_Locale
     */
    protected function initLocale()
    {
        \Zend_Locale::setDefault('es_MX');
        $locale = new \Zend_Locale('es_MX');
        $this->getRegistry()->set('Zend_Locale', $locale);
        return $locale;
    }

    /**
     * @return \Zend_Cache_Core
     */
    protected function initCache()
    {
        $cacheDir = 'cache/dates';
        if( !is_dir($cacheDir) ){
            @mkdir($cacheDir, '0777', true);
        }
        $adapter = \Zend_Cache::factory('Output','File', array('write_control' => true ), array('cache_dir' => $cacheDir));
        \Zend_Date::setOptions(array('cache' => $adapter));

        return $adapter;
    }


    /**
     * (non-PHPdoc)
     * @see Zend_Application_Bootstrap_Bootstrap::run()
     */
    public function run()
    {
        try
        {
            $container = $this->initContainer();
            $config = $this->initConfig();
            $this->initConfigureDatabase();
            $locale = $this->initLocale();
            $this->initCache();
            $view = $this->initView();

            $this->initFrontController()->dispatch();
        }
        catch (Exception $e)
        {
            die($e->getMessage());
        }
    }

    /**
     * @return \Symfony\Component\EventDispatcher\EventDispatcher
     */
    protected function getEventDispatcher(){
        return $this->getDICContainer()->get('event_dispatcher');
    }

    /**
     * @return \Symfony\Component\DependencyInjection\ContainerBuilder
     */
    private function getDICContainer(){
        return $this->container;
    }

}

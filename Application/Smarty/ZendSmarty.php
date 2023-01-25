<?php
/**
 * ##$BRAND_NAME$##
 *
 * ##$DESCRIPTION$##
 *
 * @category   Project
 * @package    Project_Views
 * @subpackage Project_Views_Smarty
 * @copyright  ##$COPYRIGHT$##
 * @author     ##$AUTHOR$##, $LastChangedBy$
 * @version    ##$VERSION$##, SVN:  $Id$
 */

namespace Application\Smarty;

/**
 * Clase que liga Smarty con la vista del ZendFramework
 *
 * @category   project
 * @package    Project_Views
 * @subpackage Project_Views_Smarty
 * @copyright  ##$COPYRIGHT$##
 */
class ZendSmarty extends \Zend_View_Abstract
{

    /**
     * Instancia
     * @var ZendSmarty
     */
    private static $instance = null;

    /**
     * Si se salta lo demas
     */
    const RENDER_NOW = null;

    /**
     * @var ProjectSmarty
     */
    private $smarty = null;

    /**
     *
     * @var string
     */
    private $layoutFile = 'layout/Layout.tpl';

    /**
     * @var string
     */
    private $controller = '';

    /**
     * @var string
     */
    private $action = '';

    /**
     * Class Constructor
     *
     * @param array [OPTIONAL] $data
     * @return ZendSmarty
     */
    public function __construct($webConfig)
    {
        parent::__construct(array());
        $configSmarty = $webConfig->smarty;
        $templateDir = $configSmarty->templateDirectory;
        $compileDir = $configSmarty->compileDirectory;
        $configDir = $configSmarty->configDirectory;
        $cacheDir = $configSmarty->cacheDirectory;
        $this->smarty = new ProjectSmarty($templateDir, $compileDir, $configDir, $cacheDir, false);
        $this->setEncoding("ISO-8859-1");
    }

    /**
     * (non-PHPdoc)
     * @see Zend_View_Abstract::__set()
     */
    public function __set($spec, $value)
    {
        $this->assign($spec, $value);
    }

    /**
     * (non-PHPdoc)
     * @see Zend_View_Abstract::__get()
     */
    public function __get($variable){
        return $this->smarty->get_template_vars($variable);
    }

    /**
     * (non-PHPdoc)
     * @see Zend_View_Abstract::assign()
     */
    public function assign($spec, $value = null)
    {
        if ($value === null) $this->smarty->assign($spec);
        else $this->smarty->assign($spec, $value);
    }

    /**
     * (non-PHPdoc)
     * @see Zend_View_Abstract::_script()
     */
    public function _script($name)
    {
        die($name);
    }

    /**
     * (non-PHPdoc)
     * @see Zend_View_Abstract::_run()
     */
    protected function _run()
    {
    }

    /**
     * (non-PHPdoc)
     * @see Zend_View_Abstract::render()
     */
    public function render($name)
    {
        $filePath = explode('/', $name);
        $controller = ($this->controller) ? $this->controller : strtolower($filePath[0]);
        $action = ($this->action) ? $this->action : ucfirst($filePath[1]);
        if( $this->layoutFile ){
            $this->smarty->displayInMasterPage($controller . '/' . $action, $this->layoutFile);
        }else{
            $this->smarty->display($controller . '/' . $action);
        }
    }

    /**
     * @param string $tplName
     * @return ZendSmarty
     */
    public function setTpl($tplName)
    {
        $this->action = $tplName . '.tpl';
        return $this;
    }

    /**
     * @return ProjectSmarty
     */
    public function getEngine()
    {
        return $this->smarty;
    }

    /**
     * @return string
     */
    public function getLayoutFile()
    {
        return $this->layoutFile;
    }

    /**
     * @param string|boolean $layoutFile
     * @return ZendSmarty
     */
    public function setLayoutFile($layoutFile)
    {
        $this->layoutFile = $layoutFile;
        return $this;
    }

}

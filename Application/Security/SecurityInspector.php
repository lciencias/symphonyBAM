<?php
/**
 * ##$BRAND_NAME$##
 *
 * ##$DESCRIPTION$##
 *
 * @category   Lib
 * @package    Lib_Security
 * @copyright  ##$COPYRIGHT$##
 * @author     ##$AUTHOR$##, $LastChangedBy$
 * @version    ##$VERSION$##, SVN:  $Id$
 */

namespace Application\Security;

use Application\Query;
use Application\Model\Bean;
use Application\Model\Factory;
use Application\Model\Catalog;

/**
 * Clase que inspecciona nuestro ambiente de trabajo
 *
 * @category   Lib
 * @package    Lib_Security
 * @copyright  ##$COPYRIGHT$##
 */
class SecurityInspector
{

    /**
     * Controladores
     * @var array
     */
    public $controllers = array();

    /**
     *
     * @var \Application\Model\Catalog\SecurityControllerCatalog
     */
    private $securityControllerCatalog;

    /**
     *
     * @var \Application\Model\Catalog\SecurityActionCatalog
     */
    private $securityActionCatalog;

    /**
     *
     * @var \Application\Model\Catalog\AccessRoleCatalog
     */
    private $accessRoleCatalog;

    /**
     * Class Constructor
     *
     * @param $securityControllerCatalog
     * @param $securityActionCatalog
     * @param $accessRoleCatalog
     * @return SecurityInspector
     */
    public function __construct($securityControllerCatalog, $securityActionCatalog, $accessRoleCatalog)
    {
        $this->securityControllerCatalog = $securityControllerCatalog;
        $this->securityActionCatalog = $securityActionCatalog;
        $this->accessRoleCatalog = $accessRoleCatalog;
        $this->seekControllers();
    }

    /**
     * Analiza nuestro workspace, lee los controllers, sus actions, las agrega a la base de datos
     */
    public function analizeWorkspace()
    {
        foreach (array_keys($this->controllers) as $baseControllerName)
        {
            $controllerFullname = $baseControllerName;
            $controllerName = $this->underscore(substr($baseControllerName, 0, -10));
            $controller = Query\SecurityControllerQuery::create()
                ->whereAdd(Bean\SecurityController::NAME, $controllerName)
                ->findOne();
            if( !($controller instanceof Bean\SecurityController ) )
            {
                $controller = Factory\SecurityControllerFactory::createFromArray(array('name' => $controllerName));
                $this->securityControllerCatalog->create($controller);
            }

            foreach( $this->getActionsByController($baseControllerName) as $actionName )
            {
                $actionFullname = $actionName;
                $actionName = $this->underscore(substr($actionName,0,-6));

                $action = Query\SecurityActionQuery::create()
                    ->whereAdd(Bean\SecurityAction::NAME, $actionName)
                    ->whereAdd(Bean\SecurityAction::ID_CONTROLLER, $controller->getIdController())
                    ->setLimit(1)
                    ->findOne();

                if( !($action instanceof Bean\SecurityAction) )
                {
                    $action = Factory\SecurityActionFactory::createFromArray(array(
                        'name' => $actionName,
                        'id_controller' => $controller->getIdController(),
                    ));
                }

                try {
                    $method = new \Zend_Reflection_Method($controllerFullname, $actionFullname);
                    $docblock = $method->getDocblock();
                    if( $docblock->hasTag('module') ){
                        $action->setTagModule(trim($docblock->getTag('module')->getDescription()));
                    }
                    if( $docblock->hasTag('action') ){
                        $action->setTagAction(trim($docblock->getTag('action')->getDescription()));
                    }
                } catch (\Exception $e) {
                }


                $this->securityActionCatalog->save($action);
            }
        }
    }


    /**
     * Obtiene las acciones de un controllador
     *
     * @param string $controllerName
     * @return array
     */
    private function getActionsByController($controllerName)
    {
        if(!array_key_exists($controllerName,$this->controllers))
          throw new Exception('No existe el controller '.$controllerName);

        require_once $this->controllers[$controllerName]['path'];

        $actions = array();
        $reflection = new \ReflectionClass($controllerName);
        foreach ($reflection->getMethods() as $method)
        {
            if( preg_match('/Action$/',$method->getName()) ){
                $actions[] = $method->getName();
            }
        }
        return $actions;
    }


    /**
     * Agrega/Elimina un permiso en la base de datos de facultades
     *
     * @param int $operation
     * @param int $idAction
     * @param int $idAccessRole
     */
    public function setPermission($operation, $idAction, $idAccessRole)
    {
        if( $operation ){
           $this->accessRoleCatalog->linkToSecurityAction($idAccessRole, $idAction);
        }else{
           $this->accessRoleCatalog->unlinkFromSecurityAction($idAccessRole, $idAction);
        }
    }

    /**
     * Método que regresa una arreglo con la lista de controlladores del sistema
     * @return array
     */
    private function seekControllers()
    {
        $front = \Zend_Controller_Front::getInstance();
        $controllers = array();
        foreach ($front->getControllerDirectory() as $controllerPath){
            if(false != ($handle = opendir($controllerPath)))
            {
                while ( false !== ($file = readdir($handle)) )
                {
                    if( preg_match('/controller\.php$/i', $file) ){
                        $controllers[basename($file,'.php')] = array(
                            'file' => $file,
                            'path' => $controllerPath .'/'. $file);
                    }
                }
                closedir($handle);
            }
        }
        $this->controllers = $controllers;
    }

     /**
     * Translates a camel case string into a string with underscores (e.g. firstName -&gt; first_name)
     * @param    string   $str    String in camel case format
     * @return    string            $str Translated into underscore format
     */
    private function underscore($str)
    {
        $str[0] = strtolower($str[0]);
        $func = create_function('$c', 'return "-" . strtolower($c[1]);');
        return preg_replace_callback('/([A-Z])/', $func, $str);
    }

}
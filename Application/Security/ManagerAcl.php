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
use Application\Model\Catalog;
use Application\Storage;

/**
 * Clase para manejar roles y permisos de los usuarios
 *
 * @category   Lib
 * @package    Lib_Security
 * @copyright  ##$COPYRIGHT$##
 */
class ManagerAcl
{
    /**
     * Lista de control de acceso
     * @var Zend_Acl $acl
     */
    protected $acl;

    /**
     * Instancia del singleton
     * @staticvar $instance
     */
    protected static $instance = null;

    /**
     * Determina si se utiliza cache o no
     * @var bool
     */
    protected $enableCache = true;

    /**
     * @var \Application\Storage\Storage
     */
    protected $cache;

    /**
     *
     * @var \Application\Model\Catalog\AccessRoleCatalog
     */
    protected $accessRoleCatalog;

    /**
     * Constructor
     */
    public function __construct($accessRoleCatalog)
    {
        $this->accessRoleCatalog = $accessRoleCatalog;
        $this->mi = microtime(true);
        if( $this->enableCache)
        {
            $this->cache = new Storage\File(array(), array('cache_dir' => 'cache/acl'));

            $this->acl = $this->cache->load('acl');
            if( !$this->acl ){
                $this->createAcl();
            }
        }
        else
        {
            $this->createAcl();
        }
        $this->mf = microtime(true);
    }

    /**
     * Genera la Lista de control de acceso
     */
    protected function createAcl()
    {
        $this->acl = new \Zend_Acl();
        $accessRoles = $this->getAccessRolesFromDatabase();
        $securityActions = $this->getSecurityActionsFromDatabase();
        $this->addAccessRoles($accessRoles);
        $this->addSecurityActions($securityActions);
        $this->grantPermissions();
        if( $this->enableCache ){
            $this->cache->save('acl', $this->acl);
        }
    }

    /**
     * Obtiene los AccessRole de la Base de Datos
     * @return array
     */
    protected function getAccessRolesFromDatabase(){
        return Query\AccessRoleQuery::create()->fetchIds();
    }

    /**
     * Obtiene las SecurityActions de la base de datos
     * @return array
     */
    protected function getSecurityActionsFromDatabase()
    {
        $securityActionCollection = Query\SecurityActionQuery::create()->find();
        $controllers = Query\SecurityControllerQuery::create()->find()->toCombo();

        $securityActions = array();
        while( $securityActionCollection->valid() )
        {
            $securityAction = $securityActionCollection->read();
            $controllerName = $controllers[$securityAction->getIdController()];
            $actionName = $securityAction->getName();
            $securityActions[$securityAction->getIdAction()] = $controllerName . '/' . $actionName;
        }
        return $securityActions;
    }

    /**
     * Obtiene la relacion entre access role y security actions
     * @return array
     */
    protected function grantPermissions()
    {
        $allPermissions = $this->accessRoleCatalog->getAllPermissions();
        $actions = $this->getSecurityActionsFromDatabase();
        foreach ($allPermissions as $idAction => $accessRoles)
        {
            foreach (array_keys($accessRoles) as $idAccessRole)
            {
                 $this->acl->allow($idAccessRole, $actions[$idAction]);
            }
        }
    }

    /**
     * Elimina el cache
     * @return unknown_type
     */
    public function clearCache()
    {
        $this->cache->remove('acl');
    }

    /**
     * Tiempos de construccion
     * @return number
     */
    public function getTimeProcessing()
    {
        return $this->mf - $this->mi;
    }

    /**
     * Agregar los accessRoles
     * @param array $accessRoles
     */
    public function addAccessRoles($accessRoles)
    {
        foreach($accessRoles as $accessRole)
        {
            $this->acl->addRole(new \Zend_Acl_Role($accessRole));
        }
    }

    /**
     * Agrega las security Actions
     * @param array $securityActions
     */
    public function addSecurityActions($securityActions)
    {
        foreach($securityActions as $securityAction)
        {
            $this->acl->add(new \Zend_Acl_Resource($securityAction));
        }
    }

    /**
     * Obtiene la Lista de control de acceso
     * @return Zend_Acl
     */
    public function getAcl()
    {
        return $this->acl;
    }

}

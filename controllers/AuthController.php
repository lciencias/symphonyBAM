<?php
/**
 * ##$BRAND_NAME$##
 *
 * ##$DESCRIPTION$##
 *
 * @category   Project
 * @package    Project_Controllers
 * @copyright  ##$COPYRIGHT$##
 * @author     ##$AUTHOR$##, $LastChangedBy$
 * @version    ##$VERSION$##, SVN:  $Id$
 */


use Application\Query\UserQuery;

use Application\Controller\BaseController;
use Application\Query;
use Application\Model\Bean;
use Application\Model\Catalog;
use Application\Security\Authentication;
use Application\Security\SecurityInspector;
use Application\Security\AuthException;
use Application\Query\SecurityActionQuery;
use Application\Model\Bean\AccessRole;
use Application\Model\Bean\SecurityAction;

/**
 * Clase AuthController que representa el controlador para las acciones de login/logout
 *
 * @category   project
 * @package    Project_Controllers
 * @copyright  ##$COPYRIGHT$##
 */
class AuthController extends BaseController
{

    /**
     * Sobrecargamos el metodo init
     */
    public function init()
    {
        $this->initI18n();
        $this->toView();
    }

    /**
     * change language the current user
     */
    public function changeLanguageAction()
    {
        $lang = $this->getRequest()->getParam('lang', 'en');
        
        if($this->getUser()) {
        	parent::init();
	        $userQuery = new UserQuery();
	        $user = $userQuery->findByPK($this->getUser()->getIdUser());
	        $user->setLanguage($lang);
	        $this->getCatalog("UserCatalog")->update($user);
        }
        
        $this->getUser()->setLanguage($lang);        
        $referer = $this->getRequest()->getServer("HTTP_REFERER");
        $this->_redirect($referer ?: "index/index");
    }

    /**
     *
     */
    public function configAction()
    {
        parent::init();
        $this->setTitle('Configuraci�n de Facultades');
        $this->view->accessRoles = Query\AccessRoleQuery::create()->whereAdd(Bean\AccessRole::STATUS, 1)->find();
        $this->view->actions = Query\SecurityActionQuery::create()->find();
        $this->view->controllers = Query\SecurityControllerQuery::create()->find();
        $this->view->permissions = $this->getCatalog('AccessRoleCatalog')->getAllPermissions();
    }

    /**
     * @module Auth
     * @action Permissions
     */
    public function permissionsAction()
    {
        parent::init();
        $idAccessRole = $this->getRequest()->getParam('id_access_role');
        $this->view->accessRole = $accessRole = Query\AccessRoleQuery::create()
            ->findByPKOrThrow($idAccessRole, $this->i18n->_("The AccessRole not exists"));

        $actions = SecurityActionQuery::create()
        	->addColumn('tag_module')
        	->addColumn('tag_action')
            ->whereAdd('tag_module', null, SecurityActionQuery::IS_NOT_NULL)
            ->whereAdd('tag_action', null, SecurityActionQuery::IS_NOT_NULL)
            ->addGroupBy('tag_module')
            ->addGroupBy('tag_action')
            ->find();
        $this->view->groupedActions = $actions->partition(function(Bean\SecurityAction $action){
            return $action->getTagModule();
        });
        $this->view->permissions = $this->getPermissionsByModules($accessRole);
    }

    /**
     * @module Auth
     * @action Permissions
     */
    public function updatePermissionsAction()
    {
        parent::init();

        $accessRoleCatalog = $this->getCatalog('AccessRoleCatalog');

        $idAccessRole = $this->getRequest()->getParam('id_access_role');
        $permissions = $this->getRequest()->getParam('permissions', array());
        $accessRole = Query\AccessRoleQuery::create()
            ->findByPKOrThrow($idAccessRole, $this->i18n->_("The AccessRole not exists"));

        try
        {
            $accessRoleCatalog->beginTransaction();

            foreach ( $this->getPermissionsByModules($accessRole) as $module => $data){
                foreach( $data as $actionName => $allowed ){
                    if( isset($permissions[$module][$actionName]) ){
                        if( !$allowed ){
                            SecurityActionQuery::create()
                            ->whereAdd('tag_module', $module)
                            ->whereAdd('tag_action', $actionName)
                            ->find()->each(function (SecurityAction $action) use($accessRole, $accessRoleCatalog){
                                $accessRoleCatalog->linkToSecurityAction($accessRole->getIdAccessRole(), $action->getIdAction());
                            });
                        }
                    }else{
                        if( $allowed ){
                            SecurityActionQuery::create()
                            ->whereAdd('tag_module', $module)
                            ->whereAdd('tag_action', $actionName)
                            ->find()->each(function (SecurityAction $action) use($accessRole, $accessRoleCatalog){
                                $accessRoleCatalog->unlinkFromSecurityAction($accessRole->getIdAccessRole(), $action->getIdAction());
                            });
                        }
                    }
                }
            }

            $accessRoleCatalog->commit();
        }
        catch (\Exception $e) {
            throw $e;
        }

        $this->getManagerAcl()->clearCache();
        $this->getMenu()->removeAllCache();

        $this->_redirect('auth/permissions/id_access_role/'.$idAccessRole);
    }

    /**
     *
     */
    private function getPermissionsByModules(AccessRole $accessRole){
        return $this->getCatalog('AccessRoleCatalog')
            ->getAllPermissionsByModules($accessRole->getIdAccessRole());
    }

    /**
     * @module Auth
     * @action Permissions
     */
    public function setPermissionAction()
    {
        parent::init();
        $securityInspector = $this->getContainer()->get('security_inspector');
        $securityInspector->setPermission($this->getRequest()->getParam('value'),$this->getRequest()->getParam('idAction'),$this->getRequest()->getParam('idAccessRole'));
        $this->getManagerAcl()->clearCache();
        die($this->getRequest()->getParam('value'));
    }

    /**
     * Inspecciona Todos los controllers y las actions, las agrega a la base de datos, y eso
     */
    public function inspectAction()
    {
        parent::init();
        $securityInspector = $this->getContainer()->get('security_inspector');
        $securityInspector->analizeWorkspace();
        $this->getManagerAcl()->clearCache();

        $this->setFlash('ok','Workspace analizado');
        $this->_redirect('auth/config');
    }

    /**
     * Accion para la pantalla de Login
     */
    public function viewLoginAction()
    {
        $this->view->contentTitle = $this->i18n->_('Login');
        $this->view->setTpl('Login');
    }
	
	/**
	 * Metodo de logueo
	 * @throws AuthException
	 */
    public function loginAction()
    {
        $username = $this->getRequest()->getParam('username');
        $password = $this->getRequest()->getParam('password');
        try
        {
           if( $username == null || $password == null ){
               throw new AuthException($this->i18n->_('You must specify user and password'));
           }
           $user = $this->getContainer()->get('autentication')->authenticate($username, $password);
           $this->getUser()->setBean($user);

           $accessRole = Query\AccessRoleQuery::create()->pk($user->getIdAccessRole())->findOne();
           $this->getUser()->setAccessRole($accessRole);
           $this->getUser()->setLanguage($user->getLanguage());

           $this->_redirect('/');
        }
        catch(AuthException $e)
        {
            $this->view->errorMessage = $e->getMessage();
            $this->view->contentTitle =  $this->i18n->_('Login');
        }
    }

    /**
     * Accion que hace logout.
     */
    public function logoutAction()
    {
        $this->getCatalog('SessionCatalog')->deleteByHash(Zend_Session::getId());
        $this->getUser()->shutdown();
        $this->_redirect('/');
    }

}

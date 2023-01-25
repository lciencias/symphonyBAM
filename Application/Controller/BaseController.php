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

namespace Application\Controller;

/**
 * Dependencias
 */
use Application\Query\UserLogQuery;

use Application\Model\Bean\UserLog;

use Application\Model\Bean\Session;
use Application\Query\SessionQuery;
use Application\Model\Bean\User;
use Application\Menu\MainMenuRenderer;
use Application\Security\Authentication;
use Application\Security\AuthException;
use Application\Security\ManagerAcl;
use Application\Menu\Menu;

/**
 * Clase abstracta de la que extenderan nuestros controladores, para agrupar instrucciones comunes
 *
 * @category   project
 * @package    Project_Controllers
 * @copyright  ##$COPYRIGHT$##
 */
abstract class BaseController extends \Zend_Controller_Action
{
	/**
	 * 
	 * @var int
	 */
	const EXPIRATION_DAYS = -30;
	/**
	 * 
	 * @var \Zend_Date
	 */
	protected $expirationDate;
    /**
     * ZendSmarty
     * @var ZendSmarty
     */
    public $view;

    /**
     *
     * @var \Zend_Translate
     */
    protected $i18n;

    /**
     * Class constructor
     *
     *
     * @param Zend_Controller_Request_Abstract $request
     * @param Zend_Controller_Response_Abstract $response
     * @param array $invokeArgs Any additional invocation arguments
     * @return void
     */
    public function __construct(\Zend_Controller_Request_Abstract $request, \Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        if( $request->isXmlHttpRequest() ){
            $response->setHeader('content-type','application/x-www-form-urlencoded; charset=iso-8859-1',true);
        }
        $this->expirationDate = new \Zend_Date();
        $this->expirationDate->setDay(self::EXPIRATION_DAYS);
        parent::__construct($request, $response, $invokeArgs);
    }

    /**
     * Init
     */
    public function init()
    {
        $this->initSecurity();
        $this->initI18n();
        $this->verifyPasswordVigency();
        $this->initMenu();
        $this->toView();        
    }

    /**
     * Init I18n
     */
    protected function initI18n()
    {
        $i18n = $this->getI18n();
        $i18n->addTranslation('data/languages/es/default.mo', 'es');
        $i18n->setLocale($this->getUser()->getLanguage('en'));
        $this->getRegistry()->set('Zend_Translate', $i18n);
        $this->view->i18n = $i18n;
        $this->i18n = $i18n;
        //echo"<pre>";print_r($this->i18n);die();
    }
    /**
     * inti Menu
     */
    protected function initMenu(){
        $menu = $this->getMenu();
        $menu->setAcl($this->getAcl());
        $menu->setRole($this->getUser()->getAccessRole()->getIdAccessRole());
        $menu->setLanguage($this->getUser()->getLanguage('en'));
        $this->view->menu = $menu->buildAndRender(new MainMenuRenderer($this->getBaseUrl()));
    }

    /**
     * Init Security
     */
    protected function initSecurity()
    {
        $this->isAutenticated();
        $idAccessRole = $this->getUser()->getAccessRole()->getIdAccessRole();
        $resource = $this->getRequest()->getControllerName().'/'.$this->getRequest()->getActionName();
        if ( !$this->getAcl()->isAllowed($idAccessRole, $resource) ){
//         	$this->setFlash('error', 'Usted no tiene permisos suficientes para acceder a esa sección ');
//         	$this->_redirect('index/index');
            throw new AuthException('Acceso Restringido para el recurso ' . $resource);
        }
        $this->eraseFilesTmp();
        $this->view->systemUser = $this->getUser()->getBean();
        $this->view->systemAccessRole = $this->getUser()->getAccessRole();
    }
    /**
     * Verifies Pasword Vigency
     */
	protected function verifyPasswordVigency(){
		$controller = $this->getRequest()->getControllerName();
		$action = $this->getRequest()->getActionName();
		$user = $this->getUser()->getBean();
		$flag = true;
		$lastUpdate = UserLogQuery::create()
		->whereAdd(UserLog::EVENT_TYPE, UserLog::CHANGE_PASSWORD)
		->whereAdd(UserLog::ID_USER, $user->getIdUser())
		->orderBy(UserLog::ID_USER_LOG,UserLogQuery::DESC)
		->findOne();
		
		if (!($lastUpdate instanceof UserLog))
			$lastUpdate = UserLogQuery::create()
			->whereAdd(UserLog::EVENT_TYPE, UserLog::CREATE)
			->whereAdd(UserLog::ID_USER, $user->getIdUser())
			->orderBy(UserLog::ID_USER_LOG,UserLogQuery::DESC)
			->findOne();
		if (!($lastUpdate instanceof UserLog)){
			$flag = false;
		}
		else {
			$timestamp = new \Zend_Date($lastUpdate->getTimestamp(), 'yyyy-MM-dd HH:mm:ss');
			$timestamp->compare($this->expirationDate);
			//TODO CHECAR LA FECHA
			/*if($timestamp->compare($this->expirationDate) == -1)
				$flag = false;*/
		}
		
		if (!$flag && $controller != 'user'){
			$this->setFlash('ok', $this->i18n->_('You must change your password, it has already expired'));
			$this->_redirect('user/edit-password/id/'.$user->getIdUser());
			
		}
	}
    /**
     *
     */
    protected function isAutenticated()
    {
        try
        {
            $user = $this->getUser()->getBean();
            if( $user == null || !($user instanceof User) ){
                throw new \Exception("No se ha iniciado session");
            }
            $session = SessionQuery::create()->whereAdd(Session::ID_USER, $user->getIdUser())->findOne();
            if( null == $session ){
                throw new \Exception("No existe la session");
            }
            if( $session->getHash() != \Zend_Session::getId() ){
                throw new \Exception("El hash no es el mismo");
            }
            $session->setLastRequest(\Zend_Date::now()->get('yyyy-MM-dd HH:mm:ss'));
            $this->getCatalog('SessionCatalog')->update($session);
        } catch (\Exception $e) {
        	
            $this->getUser()->shutdown();
            if(trim($this->getRequest()->getControllerName()) == "index"){
            		$this->_redirect('auth/view-login');
            }else{
            	echo "<script>
				window.location = '".$this->getBaseUrl()."/auth/logout';
				</script>";
            }
        }
    }

    /**
     * Variable globales a smarty
     */
    protected function toView()
    {
        // Si se envian parametros que los pase a la vista
    	$menus = array();
        if( $this->getRequest()->isPost() ){
            $this->view->post = $this->getRequest()->getParams();
        }

        if( $this->getRequest()->isXmlHttpRequest() ){
            $this->view->setLayoutFile(false);
        }
        $this->view->requestParams = $this->getRequest()->getParams();
        if(trim($this->getRequest()->getControllerName()) == "index" && trim($this->getRequest()->getActionName()) == "index"){
			$menus = $this->menuNumbers($this->getUser()->getBean()->getIdAccessRole());
        }

        $this->view->controller    = $this->getRequest()->getControllerName();
        $this->view->action        = $this->getRequest()->getActionName();
        $this->view->baseUrl       = $this->getBaseUrl();
        
        $this->view->ok = $this->getFlash('ok');
        $this->view->error = $this->getFlash('error');
        $this->view->notice = $this->getFlash('notice');
        $this->view->warning = $this->getFlash('warning');
        $this->view->note = $this->getFlash('note');
        $this->view->language = $this->getUser()->getLanguage();
		$this->view->scripts = array();
        $appSettings = $this->getRegistry()->config->appSettings;
        $this->view->contentTitle = $appSettings->titulo;
        $this->view->systemTitle =  $appSettings->titulo;
        $this->view->environment =  $appSettings->environment;
        if(count($menus) == 1){
        	$url = strtolower(trim($menus[0]['name']))."/".strtolower(trim($menus[0]['id_action']));
        	$this->_redirect($url);
        }
    }

    
    protected function menuNumbers($idAccessRole){
    	$sql = "";
    	try{
    		$sql= "SELECT d.name,c.name as id_action
					FROM pcs_common_security_actions_access_roles a 
					JOIN pcs_common_menu_items b on b.id_action = a.id_security_action 
					JOIN pcs_common_security_actions c on a.id_security_action  = c.id_action
					JOIN pcs_common_security_controllers d on c.id_controller = d.id_controller   	
					WHERE a.id_access_role = '".$idAccessRole."';";
    	return $this->getSecurityActionCatalog()->getDb()->fetchAll($sql);
    	}catch (Exception $e){
    		return array();
    	}
    }
    /**
     *
     */
    public function postDispatch(){
        $this->saveUrl();
    }


    protected function eraseFilesTmp(){
    	$resources = trim($this->getRequest()->getControllerName()).'/'.trim($this->getRequest()->getActionName());
    	if( (int) $this->getUser()->getBean()->getIdUser() > 0 && trim($resources) != "ticket-client/new" && trim($resources) != "ticket-client/deposit-transaction" && trim($resources) != "ticket-client/create"){
    		$this->getFileTmpCatalog()->beginTransaction();
    		try{
    			$del = "DELETE FROM pcs_symphony_files_tmp WHERE id_session = '".$this->getUser()->getBean()->getIdUser()."'; ";
    			$this->getFileTmpCatalog()->getDb()->query($del);
    			$this->getFileTmpCatalog()->commit();
    		}
    		catch(Exception $e){
    			$this->getFileTmpCatalog()->rollBack();
    			echo $e->getMessage();
    		}
    	}  
    }
    
    /**
     * save the url in session
     */
    protected function saveUrl()
    {
        $actions = array('error/error', 'auth/view-login', );
        $request = $this->getRequest();
        $value = $request->getControllerName().'/'.$request->getActionName();
        if( !( $request->isXmlHttpRequest() || in_array($value, $actions) || $request->isPost() )  )
        {
            $params = $request->getParams();
            unset($params['controller']);
            unset($params['action']);
            unset($params['module']);
            $this->getUser()->setLastUrl($value);
            $this->getUser()->setAttribute('params', $params, 'utilities');
        }
    }

    /**
     * @return string
     */
    protected function getBaseUrl(){
        return $this->getRequest()->getBaseUrl();
    }

    /**
     *
     * @param string $controller
     * @param string $action
     * @param array $params
     * @return string
     */
    protected function generateUrl($controller, $action, $params = array()){
        $url = $this->getRequest()->getBaseUrl() . '/';
        $url .= $controller . '/' . $action;
        foreach( $params as $param => $value ){
            $url .= "/{$param}/{$value}";
        }
        return $url;
    }

    
    protected function toFilterSelect($options){
    	return array('' => $this->i18n->_('All') ) + array_map(array($this->i18n, "_"), array_flip($options));
    }
    /**
     * @param array $options
     * @return array
     */
    protected function translateCombo($options){
        return array_map(array($this->i18n, '_'), $options);
    }

    /**
     * Guarda una variable "flash", una variable que al ser utilizada es destruida
     * @param string $varName
     * @param int|string $value
     */
    protected function setFlash($varName, $value){
        $this->getUser()->setFlash($varName, $value);
    }

    /**
     * Obtiene una variable "flash" y al ser leida esta se destruye
     * @param string $varName
     * @return int|string $value
     */
    protected function getFlash($varName, $default = null){
        return $this->getUser()->getFlash($varName, $default);
    }

    /**
     * Pone el titulo de la pagina
     * @param string $title
     */
    protected function setTitle($title)
    {
        $this->view->contentTitle = $this->getRegistry()->get('Zend_Translate')->_($title);
    }

    /**
     * Obtiene la sesion del usuario
     * @return \Application\Security\UserSession
     */
    public function getUser(){
        return $this->getContainer()->get('user_session');
    }

    /**
     * No render
     */
    protected function noRender(){
        $this->getHelper('viewRenderer')->setNoRender();
    }

    /**
     * Obtiene el registry
     * @return \Zend_Registry
     */
    public function getRegistry(){
        return \Zend_Registry::getInstance();
    }

    /**
     * @return \Symfony\Component\DependencyInjection\Container
     */
    public function getContainer(){
        return $this->getRegistry()->get('container');
    }

    /**
     *
     * @return \Application\Security\ManagerAcl
     */
    public function getManagerAcl(){
        return $this->getContainer()->get('manager_acl');
    }

    /**
     *
     * @return \Application\Menu\Menu
     */
    public function getMenu(){
        return $this->getContainer()->get('menu');
    }

    /**
     * @return \Symfony\Component\EventDispatcher\EventDispatcher
     */
    public function getEventDispatcher(){
        return $this->getContainer()->get('event_dispatcher');
    }

    /**
     * @return \Automatic\Machine
     */
    public function getTicketMachine(){
        return $this->getContainer()->get('TicketAutomata')->getMachine();
    }

    /**
     * @return \Application\Service\ServiceLevelService
     */
    public function getServiceLevelService(){
        return $this->getContainer()->get('ServiceLevelService');
    }

    /**
     * Obtiene la Lista de control de accesso
     * @return \Zend_Acl
     */
    public function getAcl(){
        return $this->getManagerAcl()->getAcl();
    }

    /**
     *
     * @param string $catalog
     * @return \Application\Model\Catalog\Catalog
     */
    public function getCatalog($catalog){
        return $this->getContainer()->get($catalog);
    }

    /**
     *
     * @return \Zend_Translate
     */
    public function getI18n(){
        return $this->getContainer()->get('i18n');
    }
    
    /**
     * @return Application\Model\Catalog\SecurityActionCatalog
     */
    private function getSecurityActionCatalog(){
    	return $this->getCatalog('SecurityActionCatalog');
    }
    
    /**
     * @return Application\Model\Catalog\FileTmpCatalog
     */
    private function getFileTmpCatalog(){
    	return $this->getCatalog('FileTmpCatalog');
    }    
}

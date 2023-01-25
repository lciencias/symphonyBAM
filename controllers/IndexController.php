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

use Application\Controller\BaseController;
use Application\Query\MenuItemQuery;
use Application\Model\Bean\MenuItem;
use Application\Query\SecurityActionQuery;
use Application\Model\Bean\SecurityAction;
use Application\Model\Bean\AccessRole;
use Application\Query\SecurityControllerQuery;

/**
 * Clase IndexController que representa el controller para la ruta default
 *
 * @category   Project
 * @package    Project_Controllers
 * @copyright  ##$COPYRIGHT$##
 */
class IndexController extends BaseController
{

    /**
     *
     * @module Home
     * @action home
     */
    public function indexAction()
    {
        $this->view->contentTitle = $this->i18n->_("Welcome");
        $this->view->actions = SecurityActionQuery::create()->find();
        $this->view->controllers = SecurityControllerQuery::create()->find();
        $this->view->allowedActions = $this->getAllowedActions();
        $this->view->setTpl('Home');
    }
    private function getAllowedActions(){
    	
    	$actions = SecurityActionQuery::create()
    	->whereAdd('AccessRole.'.AccessRole::ID_ACCESS_ROLE, $this->getUser()->getAccessRole()->getIdAccessRole())
    	->innerJoinAccessRole()
    	->find();
    	
    	$parents = MenuItemQuery::create()->whereAdd(MenuItem::ID_PARENT, NULL)->find();
    	$values = array();
    	while ($parent =$parents->read()){
    		$sons = MenuItemQuery::create()
    		->whereAdd(MenuItem::ID_PARENT, $parent->getIdMenuItem())
    		->whereAdd(MenuItem::ID_ACTION, $actions->getPrimaryKeys())
    		->find();
    		while ($son = $sons->read()){
    			$values[$parent->getName()][] = $son; 
    		}
    	}
    	return $values;
    }

}



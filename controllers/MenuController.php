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

/**
 * Dependencias
 */

use Application\Model\Factory\MenuItemFactory;

use Application\Model\Bean\MenuItem;

use Application\Query\MenuItemQuery;

use Application\Controller\BaseController;
use Application\Query;
use Application\Model\Bean;
use Application\Model\Factory;
use Application\Model\Catalog;
use Application\Menu\MainMenuRenderer;
use Application\Menu\Menu;
use Application\Menu\ManagerMenuRenderer;

/**
 * Clase AuthController que representa el controlador para las acciones de login/logout
 *
 * @category   project
 * @package    Project_Controllers
 * @copyright  ##$COPYRIGHT$##
 */
class MenuController extends BaseController
{

	/**
	 *
	 */
	public function init()
	{
		$this->getMenu()->removeAllCache();
		parent::init();
	}

	/**
	 * Administra el men�
	 */
	public function manageAction()
	{
		$this->setTitle($this->i18n->_('Configuraci�n de Facultades'));
		$this->view->actions = Query\SecurityActionQuery::create()->find();
		$this->view->controllers = Query\SecurityControllerQuery::create()
		->addAscendingOrderBy(Bean\SecurityAction::NAME)->find();
		$menu = $this->getMenu();
		$this->view->menuItems = $menu->render($menu->getFullMenu(), new ManagerMenuRenderer($this->getBaseUrl()) );
	}

	/**
	 * Agrega un item al menu
	 */
	public function addEntryAction()
	{
		$idParent = $this->getRequest()->getParam('idParent');
		$idAction = $this->getRequest()->getParam('idAction');
		$name = $this->getRequest()->getParam('name');
		$order = $this->getRequest()->getParam('order',0);

		$menuItem = Factory\MenuItemFactory::createFromArray(array(
				'id_parent' => $idParent == 0 ? null: $idParent,
				'id_action' => $idAction,
				'name' => utf8_decode($name),
				'order' => $order,
				'icon_size' => MenuItem::DEFAULT_ICON_SIZE,
		));
		$this->getCatalog("MenuItemCatalog")->create($menuItem);
		die(Zend_Json::encode(array(
				'code' => 200,
				'id' => $menuItem->getIdMenuItem(),
		)));
	}

	/**
	 * Elimina una opcion del menu, al igual que sus dependencias
	 */
	public function removeEntryAction()
	{
		$id = $this->getRequest()->getParam('id');
		$this->deleteRecursiveById($id);
		if($this->getRequest()->isXmlHttpRequest())
			die(Zend_Json::encode(array('code' => 200)));
		else
			$this->_redirect('menu/manage');
	}

	/**
	 * Metodo para eliminar un MenuItem a partir de su Id
	 * adem�s, borra los elementos dependientes
	 * @param int $idMenuItem
	 */
	private function deleteRecursiveById($idMenuItem)
	{
		$menuItemCatalog = $this->getCatalog("MenuItemCatalog");

		$childs = Query\MenuItemQuery::create()
		->whereAdd(Bean\MenuItem::ID_PARENT, $idMenuItem)
		->find();
		$childs->each(function(Bean\MenuItem $menuItem) use($menuItemCatalog){
			$menuItemCatalog->deleteById($menuItem->getIdMenuItem());
		});
		$menuItemCatalog->deleteById($idMenuItem);
	}
	/**
	 *
	 */
	public function editIconsAction(){
		$this->view->items = MenuItemQuery::create()
		->whereAdd(MenuItem::ID_PARENT, NULL, MenuItemQuery::IS_NOT_NULL)
		->find()
		->toArray();
	}
	/**
	 *
	 */
	public function saveIconsAction(){
		if($this->getRequest()->isPost()){
			$items = $this->getRequest()->getParam('items');
				
			try {
				$this->getCatalog('MenuItemCatalog')->beginTransaction();
				foreach ($items as $item){
					$menuItem = MenuItemQuery::create()->findByPK($item['id_menu_item']);
					MenuItemFactory::populate($menuItem, $item);
					$this->getCatalog('MenuItemCatalog')->update($menuItem);
				}
				$this->getCatalog('MenuItemCatalog')->commit();
			}catch (Exception $e){
				$this->getCatalog('MenuItemCatalog')->rollBack();
				$this->setFlash('error', $e->getMessage());
			}
				
		}else{
			$this->setFlash('error', $this->i18n->_('The menu cannot be saved'));
		}
		$this->setFlash('ok', $this->i18n->_('The menu was saved'));
		$this->_redirect('menu/edit-icons');
	}
}

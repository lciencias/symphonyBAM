<?php
/**
 * ##$BRAND_NAME$##
 *
 * ##$DESCRIPTION$##
 *
 * @category   Project
 * @package    Project_Menus
 * @copyright  ##$COPYRIGHT$##
 * @author     ##$AUTHOR$##, $LastChangedBy$
 * @version    ##$VERSION$##, SVN:  $Id$
 */

namespace Application\Menu;

use Application\Model\Bean\MenuItem;
use Application\Model\Catalog\MenuItemCatalog;
use Application\Query\MenuItemQuery;
use Application\Query;
use Application\Storage;

/**
 * Clase para generar los menus del sistema
 *
 * @category   project
 * @package    Project_Menus
 * @copyright  ##$COPYRIGHT$##
 */
class Menu
{

    /**
     * Arreglo donde se guarda el menu una vez generado
     * @var array
     */
    private $userMenu = null;

    /**
     * Arreglo donde se guarda el menu una vez generado
     * @var array
     */
    private $fullMenu = null;

    /**
     * Instancia singleton
     * @var Menu
     */
    private static $instance = null;

    /**
     * ACL
     * @var \Zend_Acl
     */
    private $acl = null;

    /**
     * Role
     * @var string|int
     */
    private $role = null;

    /**
     * @var \Application\Storage\Storage
     */
    private $cache = null;

    /**
     *
     * @var \Zend_Translate
     */
    protected $i18n;

    /**
     *
     * @var string
     */
    private $lang;

    /**
     * Constructor de la clase
     * @return Menu
     */
    public function __construct(){
        $this->cache = new Storage\File(array(), array('cache_dir' => 'cache/menu'));
    }

    /**
     * Genera el menu
     */
    public function build($start = array(array(
        'order' => -100,
        'idMenuItem' => 0,
        'label' => 'Symphony',
        'controller' => 'index',
        'action' => 'index',
        'resource' => 'index/index'
    ))){
        if( is_null($this->role) ){
            throw new \Exception('Necesita especificar un rol de usuario');
        }

        $this->fullMenu = $this->cache->load('menu');
        $this->userMenu = $this->cache->load('menu_' . $this->role);
        if( !$this->fullMenu )
        {

            $this->fullMenu = $this->getMenuItemsByIdParent(null, $start);
            $this->cache->save('menu', $this->fullMenu);
        }
        if( !$this->userMenu )
        {
            $this->userMenu = $this->checkPermissions($this->fullMenu);
            $this->cache->save('menu_' . $this->role, $this->userMenu);
        }
    }

    /**
     * Render the menu
     * @param array $menu
     */
    public function render($menu, AbstractMenuRenderer $renderer){
        $renderer->setI18n($this->i18n);
        return $renderer->render($menu);
    }

    /**
     *
     * @param  $menu
     * @param AbstractMenuRenderer $renderer
     * @return string
     */
    public function buildAndRender(AbstractMenuRenderer $renderer)
    {
        $keyStorage = 'menu_html_' . $this->role . '_' . $this->lang;
        if( $this->cache->exists($keyStorage) ){
            return $this->cache->load($keyStorage);
        }
        $this->build(array());
        $html = $this->render($this->getUserMenu(), $renderer);

        $this->cache->save($keyStorage, $html);

        return $html;
    }


    /**
     * Checa los permisos del usuario para cada item del menu
     * @param array $map
     */
    private function checkPermissions($map)
    {
        $userMap = array();
        foreach ($map as $id =>  $item)
        {
            foreach ($item as $key => $value)
            {
                if($key === 'pages')
                    $userMap[$id][$key] = $this->checkPermissions($value);
                else
                    $userMap[$id][$key] = $value;
            }
            if(count($userMap[$id]['pages']) === 0 && !isset($userMap[$id]['resource']) )
            {
                unset($userMap[$id]);
            }elseif ( isset($userMap[$id]['resource']) && $this->acl->has($userMap[$id]['resource'])
            &&  !$this->acl->isAllowed($this->role,$userMap[$id]['resource']) )
            {
                unset($userMap[$id]);
            }
        }
        return $userMap;
    }

    /**
     * Obtiene los items
     * @param int $idParent
     * @param Array $prepend (Un arreglo para agregar antes del resultado )
     * @return Array
     */
    private function getMenuItemsByIdParent($idParent, $prepend = array())
    {
        $return = $prepend;
        $items = MenuItemQuery::create()
            ->whereAdd(MenuItem::ID_PARENT, $idParent, is_null($idParent) ? MenuItemQuery::IS_NULL : MenuItemQuery::EQUAL)
            ->addAscendingOrderBy(MenuItem::ORDER)
            ->find();
        while( $items->valid() )
        {
            $item = $items->read();
            $controller = $this->getControllerURI($item->getIdAction());
            $action = $this->getActionURI($item->getIdAction());
            $tmp = array(
                    'order'       => $item->getOrder(),
                    'label'       => $item->getName(),
                    'controller'  => $controller,
                    'action'      => $action,
                    'icon'        => $item->getIcon(),
                    'icon_size'   => $item->getIconSize(),
                    'idMenuItem'  => $item->getIdMenuItem(),
                    'pages'       => $this->getMenuItemsByIdParent($item->getIdMenuItem())
            );
            if($action && $controller)
                $tmp['resource'] = $controller . '/' . $action;
            $return[] = $tmp;
        }
        return $return;
    }

    /**
     * Obtiene el nombre de la action
     * @param int $idAction
     * @param string
     */
    private function getControllerURI($idAction)
    {
        if (is_null($idAction) ){
            return '';
        }

        $action = Query\SecurityActionQuery::create()->pk($idAction)->findOne();
        $controller = Query\SecurityControllerQuery::create()->pk($action->getIdController())->findOne();
        return $controller->getName();
    }

    /**
     * Obtiene el nombre de la action
     * @param int $idAction
     * @param string
     */
    private function getActionURI($idAction)
    {
        if( is_null($idAction) ){
            return '';
        }

        $action = Query\SecurityActionQuery::create()->pk($idAction)->findOne();
        return $action->getName();
    }

    /**
     * Enter description here...
     *
     */
    public function setAcl(\Zend_Acl $acl)
    {
        $this->acl = $acl;
    }

    /**
     * Role
     * @param string|int
     */
    public function setRole($role)
    {
        $this->role = $role;
    }

    /**
     *
     * @param unknown_type $lang
     */
    public function setLanguage($lang = 'en'){
        $this->lang = $lang;
    }

    /**
     * @return array
     */
    public function getFullMenu()
    {
        return $this->fullMenu;
    }

    /**
     * @return array
     */
    public function getUserMenu()
    {
        return $this->userMenu;
    }

    /**
     *
     */
    public function removeAllCache(){
        $this->cache->removeAll();
    }

    /**
     *
     * @param \Zend_Translate $i18n
     */
    public function setI18n(\Zend_Translate $i18n){
        $this->i18n = $i18n;
    }

    /**
     * @return \Zend_Translate
     */
    public function getI18n(){
        return $this->i18n;
    }


}

<?php
/**
 * PCS Mexico
 *
 * Symphony Help Desk
 *
 * @copyright Copyright (c) PCS Mexico (http://pcsmexico.com)
 * @author    guadalupe, chente, $LastChangedBy$
 * @version   2
 */

namespace Application\Model\Bean;

/**
 *
 * MenuItem
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class MenuItem extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_common_menu_items';

    /**
     * Constants Fields
     */
    const ID_MENU_ITEM = 'id_menu_item';
    const ID_PARENT = 'id_parent';
    const ID_ACTION = 'id_action';
    const NAME = 'name';
    const ORDER = 'order';
    const ICON = 'icon';
    const ICON_SIZE = 'icon_size';
	/**
	 * 
	 * @var int
	 */
    const DEFAULT_ICON_SIZE = 83;
    /**
     * @var int
     */
    private $idMenuItem;


    /**
     * @var int
     */
    private $idParent;


    /**
     * @var int
     */
    private $idAction;


    /**
     * @var string
     */
    private $name;


    /**
     * @var int
     */
    private $order;

    /**
     *
     * @var string
     */
    private $icon;

    /**
     *
     * @var int
     */
    private $iconSize;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdMenuItem();
    }


    /**
     * @return int
     */
    public function getIdMenuItem(){
        return $this->idMenuItem;
    }

    /**
     * @param int $idMenuItem
     * @return MenuItem
     */
    public function setIdMenuItem($idMenuItem){
        $this->idMenuItem = $idMenuItem;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdParent(){
        return $this->idParent;
    }

    /**
     * @param int $idParent
     * @return MenuItem
     */
    public function setIdParent($idParent){
        $this->idParent = $idParent;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdAction(){
        return $this->idAction;
    }

    /**
     * @param int $idAction
     * @return MenuItem
     */
    public function setIdAction($idAction){
        $this->idAction = $idAction;
        return $this;
    }


    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @param string $name
     * @return MenuItem
     */
    public function setName($name){
        $this->name = $name;
        return $this;
    }


    /**
     * @return int
     */
    public function getOrder(){
        return $this->order;
    }

    /**
     * @param int $order
     * @return MenuItem
     */
    public function setOrder($order){
        $this->order = $order;
        return $this;
    }

    /**
     *
     * @param string $icon
     */
    public function setIcon($icon){
        $this->icon = $icon;
    }

    /**
     * @return string
     */
    public function getIcon(){
        return $this->icon;
    }

    /**
     * @param number $iconSize
     */
    public function setIconSize($iconSize){
        $this->iconSize = $iconSize;
    }

    /**
     * @return number
     */
    public function getIconSize(){
        return $this->iconSize;
    }

    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_menu_item' => $this->getIdMenuItem(),
            'id_parent' => $this->getIdParent(),
            'id_action' => $this->getIdAction(),
            'name' => $this->getName(),
            'order' => $this->getOrder(),
            'icon' => $this->getIcon(),
            'icon_size' => $this->getIconSize(),
        );
        return $array;
    }

}
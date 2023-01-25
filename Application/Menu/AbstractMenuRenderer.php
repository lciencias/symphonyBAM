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

/**
 * Clase para generar los menus del sistema
 *
 * @category   project
 * @package    Project_Menus
 * @copyright  ##$COPYRIGHT$##
 */
abstract class AbstractMenuRenderer
{

  /**
   * Constructor
   * @param string $baseUrl
   * @return AbstractMenuRenderer
   */
  public function __construct($baseUrl)
  {
    $this->document = new \DOMDocument();
    $this->baseUrl = $baseUrl;
  }

  /**
   * BaseUrl
   * @var string
   */
  protected $baseUrl = '';

  /**
   * Menu
   * @var array
   */
  protected $menu = array();

  /**
   * Ul Id
   * @var string
   */
  protected $ulId = 'mega-menu-1';

  /**
   * Document
   * @var DOMDocument
   */
  protected $document = null;

  /**
   * Ul Class
   * @var string
   */
  protected $ulClass = 'mega-menu';

  /**
   *
   * @var \Zend_Translate
   */
  protected $i18n;

  /**
   * Render the menu
   */
  abstract public function render($menu);


  /**
   * MenuArray -> HTML
   * @param array
   * @param string $id
   * @param string $class
   * @return DomElement
   */
  protected function htmlify($menu, $id = '', $class = '')
  {
    $ul = $this->document->createElement('ul');
    if($class)
    {
      $classAttr = new \DOMAttr('class',$class);
      $ul->setAttributeNode($classAttr);
    }
    if($id)
    {
      $idAttr = new \DOMAttr('id',$id);
      $ul->setAttributeNode($idAttr);
    }


    foreach( $menu as $i => $item )
    {
        $hasSubmenu = isset($item['pages']) && $item['pages'];
        $li = $this->addLiElement($item, $hasSubmenu ? "menu{$i}" : null);
        if( $hasSubmenu ){
            $li->appendChild( $this->htmlify($item['pages'], '', '') );
            $li->setAttributeNode(new \DOMAttr('class', ''));
        }
        $ul->appendChild($li);
    }
    return $ul;
  }

  /**
   * Add li Element
   * @param array $item
   * @return DomElement
   */
  protected function addLiElement($item, $dropdown = null)
  {
      $li = $this->document->createElement('li');
      $a =  $this->document->createElement('a', utf8_encode($this->getI18n()->_($item['label'])));

      if( null != $dropdown ){
          $arrow = $this->document->createElement('b');
          $arrow->setAttributeNode(new \DOMAttr('class', 'caret'));
          $a->appendChild($arrow);
          $a->setAttributeNode(new \DOMAttr('class', ''));
      }

      if( $item['controller'] && $item['action'] )
      {
          $resource = implode('/',array($this->baseUrl, $item['controller'], $item['action']));
          $href = new \DOMAttr('href', $resource);
          $a->setAttributeNode($href);
      }

      $li->appendChild($a);

      if( null == $dropdown ){
          $ulint = $this->document->createElement('ul');
          $liint = $this->document->createElement('li');
          $aint =  $this->document->createElement('a');
          $liint->setAttributeNode(new \DOMAttr('class', 'center'));
          $imgint = $this->document->createElement('img');
          $iconUrl = $item['icon'] ?: '/images/template/menu-icons/security.png';
          $imgint->setAttributeNode(new \DOMAttr('src', $this->baseUrl . $iconUrl));
          $iconSize = $item['icon_size'] ?: 64;
          $imgint->setAttributeNode(new \DOMAttr('style', "height: {$iconSize}px;"));

          $aint->setAttributeNode(new \DOMAttr('href', $resource ?: '#'));
          $aint->appendChild($imgint);


          $liint->appendChild($aint);
          $ulint->appendChild($liint);
          $li->appendChild($ulint);
      }

      return $li;
  }

  /**
   * @return string
   */
  public function getUlClass()
  {
    return $this->ulClass;
  }

  /**
   * @return string
   */
  public function getUlId()
  {
    return $this->ulId;
  }

  /**
   * @param string $ulClass
   */
  public function setUlClass($ulClass)
  {
    $this->ulClass = $ulClass;
  }

  /**
   * @param string $ulId
   */
  public function setUlId($ulId)
  {
    $this->ulId = $ulId;
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

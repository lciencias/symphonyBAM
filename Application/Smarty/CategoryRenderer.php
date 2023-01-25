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
 *
 * @author chente
 *
 */
class CategoryRenderer
{
    /**
     *
     * @var unknown_type
     */
    protected $params;

    /**
     *
     * @var unknown_type
     */
    protected $smarty;

    /**
     *
     * @var unknown_type
     */
    protected $template;

    /**
     *
     * @param unknown_type $name
     * @param unknown_type $params
     * @param unknown_type $smarty
     * @param unknown_type $template
     * @return CategoryRenderer
     */
    public static function factory($name, $params, $smarty, $template){
        $className = __CLASS__;
        if( $name == 'list' ){
            $className = "Application\\Smarty\\ListCategoryRenderer";
        }else if( $name == 'select' ){
            $className = "Application\\Smarty\\SelectCategoryRenderer";
        }else if( $name == 'select-standart' ){
            $className = "Application\\Smarty\\SelectStandartCategoryRenderer";
        }
        return new $className($params, $smarty, $template);
    }

    /**
     *
     * @param unknown_type $params
     * @param unknown_type $smarty
     * @param unknown_type $template
     */
    public function __construct($params, $smarty, $template){
        $this->params = $params;
        $this->smarty = $smarty;
        $this->template = $template;
    }

    /**
     *
     * @param unknown_type $category
     * @param unknown_type $isLeaf
     * @param unknown_type $isBranch
     * @param unknown_type $children
     */
    protected function renderLabel(Category $category, $isLeaf, $isBranch, $children){
       return $this->getI18n()->_($category->getName());
    }

    /**
     *
     * @param Category $category
     * @param unknown_type $isLeaf
     * @param unknown_type $isBranch
     * @param unknown_type $children
     */
    protected function renderCategory($category, $isLeaf, $isBranch, $children){
        $html = "<li>";
        $class = $isBranch ? "folder" : "file";
        $label = $this->renderLabel($category, $isLeaf, $isBranch, $children);
        $html .= "<span class='{$class}'>{$label}</span>";
        if( $isBranch ){
            $html .= $this->renderCategories($children);
        }
        $html .= "</li>";
        return $html;
    }

    /**
     *
     * @param unknown_type $categories
     */
    protected function renderCategories($categories, $attributes = array()){
        $attrHtml = "";
        foreach ($attributes as $id => $value){
            $attrHtml .= ' ' . $id . '="' . $value . '"';
        }
        $html = "<ul{$attrHtml}>";
        foreach ( $categories as $idCategory => $array){
            $category = $array['category'];
            $isLeaf = $array['isLeaf'];
            $isBranch = $array['isBranch'];
            $children = $array['children'];
            $html .= $this->renderCategory($category, $isLeaf, $isBranch, $children);
        }
        $html .= "</ul>";
        return $html;
    }

    /**
     *
     * @param unknown_type $categories
     * @param unknown_type $attributes
     * @return string
     */
    public function render($categories, $attributes = array()){
        return $this->renderCategories($categories, $attributes);
    }

    /**
     *
     * @param unknown_type $name
     * @param unknown_type $title
     * @return string
     */
    protected function icon($name, $title){
        $baseUrl = $this->getBaseUrl();
        $iconUrl = "{$baseUrl}/images/template/icons";
        return " <img src='{$iconUrl}/{$name}.png' title='{$title}' alt='{$title}' />{$title}";
    }

    /**
     * @return string
     */
    protected function getBaseUrl(){
        return $this->smarty->getTemplateVars('baseUrl');
    }

    /**
     * @return \Zend_Translate
     */
    protected function getI18n(){
        return \Zend_Registry::get('container')->get('i18n');
    }

}
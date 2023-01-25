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

use Application\Model\Bean\Category;

class SelectStandartCategoryRenderer extends CategoryRenderer
{
    /**
     *
     * @var unknown_type
     */
    private $level = 1;

    /**
     *
     * @param unknown_type $category
     * @param unknown_type $isLeaf
     * @param unknown_type $isBranch
     * @param unknown_type $children
     */
    protected function renderLabel(Category $category, $isLeaf, $isBranch, $children){
        $isSelected = isset($this->params['selected']) && $this->params['selected'] == $category->getIdCategory();
        $extra = $isSelected ? "selected='selected'" : "";
        return "<option value='{$category->getIdCategory()}' {$extra}>{$this->padLabel($this->getI18n()->_($category->getName()))}</option>";
    }

    /**
     *
     * @param Category $category
     * @param unknown_type $isLeaf
     * @param unknown_type $isBranch
     * @param unknown_type $children
     */
    protected function renderCategory($category, $isLeaf, $isBranch, $children){

        if( $isBranch ){
            $this->level++;
            $html .= $this->renderCategories($children);
            $this->level--;
        }else{
            $html .= $this->renderLabel($category, $isLeaf, $isBranch, $children);
        }


        return $html;
    }

    /**
     *
     * @param unknown_type $categories
     */
    protected function renderCategories($categories, $attributes = array())
    {
        foreach ( $categories as $idCategory => $array){
            $category = $array['category'];
            $isLeaf = $array['isLeaf'];
            $isBranch = $array['isBranch'];
            $children = $array['children'];
            if( $isBranch ){
                $html .= "<optgroup label='{$this->padLabel($category->getName())}'>";
            }
            $html .= $this->renderCategory($category, $isLeaf, $isBranch, $children);
            if( $isBranch ){
                $html .= "</optgroup>";
            }
        }
        return $html;
    }

    /**
     * @return string
     */
    protected function padLabel($label){
        return str_repeat("&nbsp;", $this->level * 2) . $label;
    }
}
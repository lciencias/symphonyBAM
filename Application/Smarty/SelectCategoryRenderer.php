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

class SelectCategoryRenderer extends CategoryRenderer
{

    /**
     *
     * @param unknown_type $category
     * @param unknown_type $isLeaf
     * @param unknown_type $isBranch
     * @param unknown_type $children
     */

    protected function renderLabel(Category $category, $isLeaf, $isBranch, $children){

        $html = "";

        if( $isLeaf ){
            $isSelected = isset($this->params['selected']) && $this->params['selected'] == $category->getIdCategory();
            $selected = $isSelected ? "checked='checked' " : "";
            $html .= "<input type='radio' name='id_category' class='required' value='{$category->getIdCategory()}' {$selected}/>";
        }

        $html .= $this->getI18n()->_($category->getName());

        return $html;
    }

}
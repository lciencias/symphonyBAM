<?php
/**
 * ##$BRAND_NAME$##
 *
 * ##$DESCRIPTION$##
 *
 * @clientCategory   Project
 * @package    Project_Views
 * @subpackage Project_Views_Smarty
 * @copyright  ##$COPYRIGHT$##
 * @author     ##$AUTHOR$##, $LastChangedBy$
 * @version    ##$VERSION$##, SVN:  $Id$
 */
namespace Application\Smarty;

use Application\Model\Bean\ClientCategory;

class SelectClientCategoryRenderer extends ClientCategoryRenderer
{

    /**
     *
     * @param unknown_type $clientCategory
     * @param unknown_type $isLeaf
     * @param unknown_type $isBranch
     * @param unknown_type $children
     */
    protected function renderLabel(ClientCategory $clientCategory, $isLeaf, $isBranch, $children){
        $html = "";

        if( $isLeaf ){
            $isSelected = isset($this->params['selected']) && $this->params['selected'] == $clientCategory->getIdClientCategory();
            $selected = $isSelected ? "checked='checked' " : "";
            $html .= "<input type='radio' name='id_client_category' id='id_client_category' class='client-category'  value='{$clientCategory->getIdClientCategory()}' {$selected}/>";
        }

        $html .= $this->getI18n()->_($clientCategory->getName());

        return $html;
    }

}
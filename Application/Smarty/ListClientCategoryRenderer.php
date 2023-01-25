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

class ListClientCategoryRenderer extends ClientCategoryRenderer
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

        $baseUrl = $this->getBaseUrl();
        $moduleUrl = "{$baseUrl}/client-category";
        $iconAdd = $this->icon('add', $this->getI18n()->_('Add'));
        $iconEdit = $this->icon("pencil", $this->getI18n()->_("Edit"));
        $iconDelete = $this->icon("delete", $this->getI18n()->_("Remove"));
        $iconActive = $this->icon('tick', $this->getI18n()->_('Reactive'));
         
        $html .= $this->getI18n()->_($clientCategory->getName());
        $html .= "<span class='invisible'>";
        $html .= " <a href='{$moduleUrl}/new/idParent/{$clientCategory->getIdClientCategory()}'>{$iconAdd}</a>";
        $html .= " <a href='{$moduleUrl}/edit/id/{$clientCategory->getIdClientCategory()}'>{$iconEdit}</a>";
        if ($clientCategory->isActive())
        	$html .= " <a href='{$moduleUrl}/delete/id/{$clientCategory->getIdClientCategory()}' class='deactivate'>{$iconDelete}</a>";
        else
        	$html .= " <a href='{$moduleUrl}/reactivate/id/{$clientCategory->getIdClientCategory()}' class='activate'>{$iconActive}</a>";
        $html .= "</span>";

        return $html;
    }



}
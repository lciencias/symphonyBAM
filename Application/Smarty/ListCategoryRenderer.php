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

class ListCategoryRenderer extends ClientCategoryRenderer
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

        $baseUrl = $this->getBaseUrl();
        $moduleUrl = "{$baseUrl}/category";
        $iconAdd = $this->icon('add', $this->getI18n()->_('Add'));
        $iconEdit = $this->icon("pencil", $this->getI18n()->_("Edit"));
        $iconDelete = $this->icon("delete", $this->getI18n()->_("Remove"));
        $iconActive = $this->icon('tick', $this->getI18n()->_('Reactive'));
        
        $html .= $this->getI18n()->_($category->getName());
        $html .= "<span class='invisible'>";
        $html .= " <a href='{$moduleUrl}/new/id_company/{$category->getIdCompany()}/idParent/{$category->getIdCategory()}'>{$iconAdd}</a>";
        $html .= " <a href='{$moduleUrl}/edit/id/{$category->getIdCategory()}'>{$iconEdit}</a>";
        
        $html .= " <a href='{$moduleUrl}/delete/id/{$category->getIdCategory()}' class='deactivate'>{$iconDelete}</a>";
        
        if ($category->isActive())
        	$html .= " <a href='{$moduleUrl}/delete/id/{$category->getIdCategory()}' class='deactivate'>{$iconDelete}</a>";
        else
        	$html .= " <a href='{$moduleUrl}/reactivate/id/{$category->getIdCategory()}' class='activate'>{$iconActive}</a>";
        
        $html .= "</span>";

        return $html;
    }



}
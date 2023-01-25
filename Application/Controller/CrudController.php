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

namespace Application\Controller;

/**
 * Clase abstracta para los CRUDS
 *
 * @category   project
 * @package    Project_Controllers
 * @copyright  ##$COPYRIGHT$##
 */
abstract class CrudController extends BaseController
{

    /**
     * default max per page pagination
     * @return number
     */
    protected function getMaxPerPage(){
        return 6;
    }

    /**
     *
     * @param array $options
     * @return array
     */
    protected function toFilterSelect($options){
        return array('' => $this->i18n->_('All') ) + array_map(array($this->i18n, "_"), array_flip($options));
    }

    protected function toFilterSelectCombo($options){
    	return array('' => $this->i18n->_('') ) + array_map(array($this->i18n, "_"), $options);
    }
    
    /**
     *
     * @param int $total
     * @param int $page
     * @return \Zend_Paginator
     */
    protected function createPaginator($total, $page){
        $paginator = \Zend_Paginator::factory($total);
        $paginator->setItemCountPerPage($this->getMaxPerPage());
        $paginator->setCurrentPageNumber($page);
        return $paginator;
    }

    /**
     * Form for new objects
     */
    abstract public function newAction();

    /**
     * list all objects
     */
    abstract public function listAction();

    /**
     * delete an object
     */
    abstract public function deleteAction();

    /**
     * Form to edit an object
     */
    abstract public function editAction();

    /**
     * Create an Object
     */
    abstract public function createAction();

    /**
     * Update an Object
     */
    abstract public function updateAction();

}


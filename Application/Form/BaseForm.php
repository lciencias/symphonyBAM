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

namespace Application\Form;

use Zend_View as ZendView;

/**
 *
 * BaseForm
 * @author chente
 *
 */
class BaseForm extends \ZFriendly\Form\Twitter{

    /**
     * @var \Application\Validator\BaseValidator $validator
     */
    protected $validator;

    /**
     * @var \Application\Filter\BaseFilter $filter
     */
    protected $filter;

    /**
     * @var array
     */
    protected $elements = array();

    /**
     * init
     */
    public function init(){
        parent::init();
        $view = \Zend_Registry::getInstance()->get('container')->get('zend_smarty');
        $this->setView($view);
    }

    /**
     * @param string $fieldName
     * @return \Zend_Form_Element
     */
    public function getFor($fieldName){
         if( !isset($this->elements[$fieldName]) ){
             throw new \InvalidArgumentException("No existe el elemento ". $fieldName);
         }
         return $this->elements[$fieldName];
    }

}

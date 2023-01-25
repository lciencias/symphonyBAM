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

use Application\Model\Bean\Person;

use Application\Query\PersonQuery;

use Application\Query\UserQuery;

use Application\Model\Bean\Employee;

use Application\Model\Bean\User;
use Application\Model\Bean\Group;
use Application\Validator\UserValidator;
use Application\Filter\UserFilter;
use Application\Query\EmployeeQuery;
use Application\Query\GroupQuery;
use \Zend_Form_Element_Text as ElementText;

/**
 *
 * UserForm
 * @author chente
 *
 */
class UserForm extends BaseForm{

    /**
     * init
     */
    public function init()
    {
        parent::init();
        $this->validator = new UserValidator();
        $this->filter = new UserFilter();

        $this->initFullNameElement();
        $this->initUsernameElement();
        $this->initPasswordElement();
        $this->initConfirmPasswordElement();
        $this->initIdAccessRoleElement();
        $this->initGroupElement();
        $this->initStatusElement();
    }


    /**
     *
     */
    protected function initIdAccessRoleElement()
    {
        $element = new \Zend_Form_Element_Select('id_access_role');
        $optionsAccessRole = \Application\Query\AccessRoleQuery::create()
            ->actives()->find()->toCombo();
        $element->addMultiOptions($optionsAccessRole);
        $element->setLabel($this->getTranslator()->_('AccessRole'));
        $element->addValidator($this->validator->getFor('id_access_role'));
        $element->addFilter($this->filter->getFor('id_access_role'));
        $element->setRequired(true);
        $element->setAttribs(array('class' => 'span4'));
        $this->addElement($element);
        $this->elements['id_access_role'] = $element;
    }

    /**
     *
     */
    protected function initUsernameElement()
    {
        $element = new ElementText('username');
        $element->setLabel($this->getTranslator()->_('Username'));
        $element->addValidator($this->validator->getFor('username'));
        $element->addFilter($this->filter->getFor('username'));
        $element->setRequired(true);
        $this->addElement($element);
        $this->elements['username'] = $element;
    }

    /**
     *
     */
    protected function initPasswordElement()
    {
        $element = new \Zend_Form_Element_Password('password');
        $element->setLabel($this->getTranslator()->_('Password'));
        $element->addValidator($this->validator->getFor('password'));
        $element->addFilter($this->filter->getFor('password'));
        $element->setAttribs(array('class'=> 'required password'));
        $element->setRequired();
        $this->addElement($element);
        $this->elements['password'] = $element;
    }

    protected function initConfirmPasswordElement()
    {
        $element = new \Zend_Form_Element_Password('password_confirm');
        $element->setLabel($this->getTranslator()->_('Password Confirm'));
        $element->addValidator($this->validator->getFor('password'));
        $element->addFilter($this->filter->getFor('password'));
        $element->setAttribs(array('class'=> 'required'));
        $this->addElement($element);
        $this->elements['confirm_password'] = $element;
    }

    /**
     *
     */
    protected function initStatusElement()
    {
        $element = new \Zend_Form_Element_Hidden('status');
        $option = 1;
        $element->setValue($option);
        $this->addElement($element);
        $this->elements['status'] = $element;
    }

    /**
     *
     */
    protected function initGroupElement()
    {
        $element = new \Zend_Form_Element_Multiselect('group');
        $options = GroupQuery::create()
            ->actives()->find()->toCombo();

        $element->addMultiOptions($options);
        $element->setLabel($this->getTranslator()->_('Group'));
        $element->addValidator($this->validator->getFor('group'));
        $element->addFilter($this->filter->getFor('group'));
        $element->setAttribs(array('class' => 'span4'));
        $this->addElement($element);
        $this->elements['group'] = $element;
    }

    /**
     *
     * Enter description here ...
     * @return multitype:NULL
     */
    protected function initFullNameElement()
    {
        $element = new \Zend_Form_Element_Select('id_employee');
        $employees = EmployeeQuery::create()
            ->withoutUser()
            ->actives()
            ->find();

        $element->addMultiOptions($employees->toCombo());
        $element->setLabel($this->getTranslator()->_('Employee'));
        $element->addValidator($this->validator->getFor('id_employee'));
        $element->addFilter($this->filter->getFor('id_employee'));
        $element->setRequired();
        $element->setAttribs(array('class' => 'span4'));
        $this->addElement($element);
        $this->elements['id_employee'] = $element;

    }
}
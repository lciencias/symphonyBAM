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
class EditUserForm extends BaseForm
{

    /**
     *
     * @var User
     */
    protected $user;

    /**
     *
     * @param User $user
     */
    public function setUser($user){
        $this->user = $user;
    }

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
        $element->setLabel($this->getTranslator()->_('AccessRole'));
        $element->addFilter($this->filter->getFor('id_access_role'));
        $element->setRequired(true);

        $options = \Application\Query\AccessRoleQuery::create()->actives()->find();
        if( !$options->containsIndex($this->user->getIdAccessRole()) ){
            $options = $options->merge(
                \Application\Query\AccessRoleQuery::create()->pk($this->user->getIdAccessRole())->find()
            );
        }
        $element->addMultiOptions($options->toCombo());

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
        $element->addFilter($this->filter->getFor('password'));
        $this->addElement($element);
        $this->elements['password'] = $element;
    }

    protected function initConfirmPasswordElement()
    {
        $element = new \Zend_Form_Element_Password('password_confirm');
        $element->setLabel($this->getTranslator()->_('Password Confirm'));
        $element->addFilter($this->filter->getFor('password'));
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
        $options = GroupQuery::create()->actives()->find();

        $options = $options->merge(
            GroupQuery::create()->innerJoinUser()->whereAdd('User.id_user', $this->user->getIdUser())->find()
        );

        $element->addMultiOptions($options->toCombo());
        $element->setLabel($this->getTranslator()->_('Groups'));
        $element->addFilter($this->filter->getFor('group'));


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
        $employees = EmployeeQuery::create()->pk($this->user->getIdEmployee())->find();

        $element->addMultiOptions($employees->toCombo());
        $element->setLabel($this->getTranslator()->_('Employee'));
        $element->setAttrib('disabled', 'disabled');
        $element->addFilter($this->filter->getFor('id_employee'));

        $this->addElement($element);
        $this->elements['id_employee'] = $element;

    }
}
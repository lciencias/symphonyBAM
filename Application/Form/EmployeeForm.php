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

use Application\Query\CompanyQuery;

use Application\Model\Bean\Company;

use Application\Model\Bean\Group;

use Application\Model\Bean\Employee;

use Application\Validator\EmployeeValidator;
use Application\Filter\EmployeeFilter;

use \Zend_Form_Element_Text as ElementText;

/**
 *
 * EmployeeForm
 * @author chente
 *
 */
class EmployeeForm extends PersonForm{

    /**
     * init
     */
    public function init()
    {
        parent::init();
        $this->validator = new EmployeeValidator();
        $this->filter = new EmployeeFilter();

        $this->initIdCompanyElement();
        $this->initIdPositionElement();
        $this->initIdAreaElement();
        $this->initIdLocationElement();
        $this->initStatusEmployeeElement();
        $this->initIsVipElement();
    }


    /**
     *
     */
    protected function initIdPositionElement()
    {
        $element = new \Zend_Form_Element_Select('id_position', array('registerInArrayValidator' => false));
        $options = array( '' => 'Select');
        $element->addMultiOptions($options);
        $element->setLabel($this->getTranslator()->_('Position'));
        $element->addValidator($this->validator->getFor('id_position'));
        $element->addFilter($this->filter->getFor('id_position'));
        $element->setRequired(true);
        $element->setAttribs(array('class' => 'span4'));
        $this->addElement($element);
        $this->elements['id_position'] = $element;
    }

    /**
     *
     */
    protected function initIdLocationElement()
    {
        $element = new \Zend_Form_Element_Select('id_location', array('registerInArrayValidator' => false));
        $options = array( '' => 'Select');
        $element->addMultiOptions($options);
        $element->setLabel($this->getTranslator()->_('Location'));
        $element->addValidator($this->validator->getFor('id_location'));
        $element->addFilter($this->filter->getFor('id_location'));
        $element->setRequired(true);
        $element->setAttribs(array('class' => 'span4'));
        $this->addElement($element);
        $this->elements['id_location'] = $element;
    }

    /**
     *
     */
    protected function initIdAreaElement()
    {
        $element = new \Zend_Form_Element_Select('id_area', array('registerInArrayValidator' => false));
        $options = array( '' => 'Select');
        $element->addMultiOptions($options);
        $element->setLabel($this->getTranslator()->_('Area'));
        $element->addValidator($this->validator->getFor('id_area'));
        $element->addFilter($this->filter->getFor('id_area'));
        $element->setRequired(true);
        $element->setAttribs(array('class' => 'span4'));
        $this->addElement($element);
        $this->elements['id_area'] = $element;
    }

    /**
     *
     */
    protected function initStatusEmployeeElement()
    {
        $element = new \Zend_Form_Element_Hidden('status_employee');
        $option = 1;
        $element->setValue($option);
        $this->addElement($element);
        $this->elements['status_employee'] = $element;
    }

    /**
     *
     */
    protected function initIsVipElement()
    {
        $element = new \Zend_Form_Element_Checkbox('is_vip');
        $element->setLabel($this->getTranslator()->_('IsVip'));
        $element->addValidator($this->validator->getFor('is_vip'));
        $element->addFilter($this->filter->getFor('is_vip'));
        $this->addElement($element);
        $this->elements['is_vip'] = $element;
    }

    /**
     *
     */
    protected function initIdCompanyElement()
    {
        $element = new \Zend_Form_Element_Select('id_company');
        $optionsCompany = CompanyQuery::create()->filter(array(Company::STATUS => Company::$Status['Active']))->find()->toCombo();
        $options =  $optionsCompany;
        $element->addMultiOptions($optionsCompany);
        $element->setLabel($this->getTranslator()->_('Company'));
        $element->addValidator($this->validator->getFor('id_company'));
        $element->addFilter($this->filter->getFor('id_company'));
        $element->setRequired(true);
        $element->setAttribs(array('class' => 'span4'));
        $this->addElement($element);
        $this->elements['id_company'] = $element;
    }

}
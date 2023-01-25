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

use Application\Validator\TemplateEmailValidator;
use Application\Filter\TemplateEmailFilter;

use \Zend_Form_Element_Text as ElementText;

/**
 *
 * TemplateEmailForm
 * @author chente
 *
 */
class TemplateEmailForm extends BaseForm{

    /**
     * init
     */
    public function init()
    {
        parent::init();
        $this->validator = new TemplateEmailValidator();
        $this->filter = new TemplateEmailFilter();

        $this->initIdCompanyElement();
        $this->initNameElement();
        $this->initSubjectElement();
        $this->initBodyElement();
        $this->initEventElement();
        $this->initStatusElement();
        $this->initToEmployeeElement();
        $this->initToUserElement();
        $this->initToGroupElement();
        $this->initToEscalationElement();
    }


    /**
     *
     */
    protected function initIdCompanyElement()
    {
        $element = new \Zend_Form_Element_Select('id_company');
        $options = \Application\Query\CompanyQuery::create()->find()->toCombo();
        $element->addMultiOptions($options);
        $element->setLabel($this->getTranslator()->_('IdCompany'));
        $element->addValidator($this->validator->getFor('id_company'));
        $element->addFilter($this->filter->getFor('id_company'));
        $element->setRequired(true);
        $element->setAttribs(array('class' => 'span4'));
        $this->addElement($element);
        $this->elements['id_company'] = $element;
    }

    /**
     *
     */
    protected function initNameElement()
    {
        $element = new ElementText('name');
        $element->setLabel($this->getTranslator()->_('Name'));
        $element->addValidator($this->validator->getFor('name'));
        $element->addFilter($this->filter->getFor('name'));
        $element->setRequired(true);
        $this->addElement($element);
        $this->elements['name'] = $element;
    }

    /**
     *
     */
    protected function initSubjectElement()
    {
        $element = new ElementText('subject');
        $element->setLabel($this->getTranslator()->_('Subject'));
        $element->addValidator($this->validator->getFor('subject'));
        $element->addFilter($this->filter->getFor('subject'));
        $element->setRequired(true);
        $this->addElement($element);
        $this->elements['subject'] = $element;
    }

    /**
     *
     */
    protected function initBodyElement()
    {
        $element = new ElementText('body');
        $element->setLabel($this->getTranslator()->_('Body'));
        $element->addValidator($this->validator->getFor('body'));
        $element->addFilter($this->filter->getFor('body'));
        $element->setRequired(true);
        $this->addElement($element);
        $this->elements['body'] = $element;
    }

    /**
     *
     */
    protected function initEventElement()
    {
        $element = new ElementText('event');
        $element->setLabel($this->getTranslator()->_('Event'));
        $element->addValidator($this->validator->getFor('event'));
        $element->addFilter($this->filter->getFor('event'));
        $element->setRequired(true);
        $this->addElement($element);
        $this->elements['event'] = $element;
    }

    /**
     *
     */
    protected function initStatusElement()
    {
        $element = new ElementText('status');
        $element->setLabel($this->getTranslator()->_('Status'));
        $element->addValidator($this->validator->getFor('status'));
        $element->addFilter($this->filter->getFor('status'));
        $element->setRequired(true);
        $this->addElement($element);
        $this->elements['status'] = $element;
    }

    /**
     *
     */
    protected function initToEmployeeElement()
    {
        $element = new \Zend_Form_Element_Checkbox('to_employee');
        $element->setLabel($this->getTranslator()->_('ToEmployee'));
        $element->addValidator($this->validator->getFor('to_employee'));
        $element->addFilter($this->filter->getFor('to_employee'));
        $element->setRequired(true);
        $this->addElement($element);
        $this->elements['to_employee'] = $element;
    }

    /**
     *
     */
    protected function initToUserElement()
    {
        $element = new \Zend_Form_Element_Checkbox('to_user');
        $element->setLabel($this->getTranslator()->_('ToUser'));
        $element->addValidator($this->validator->getFor('to_user'));
        $element->addFilter($this->filter->getFor('to_user'));
        $element->setRequired(true);
        $this->addElement($element);
        $this->elements['to_user'] = $element;
    }

    /**
     *
     */
    protected function initToGroupElement()
    {
        $element = new \Zend_Form_Element_Checkbox('to_group');
        $element->setLabel($this->getTranslator()->_('ToGroup'));
        $element->addValidator($this->validator->getFor('to_group'));
        $element->addFilter($this->filter->getFor('to_group'));
        $element->setRequired(true);
        $this->addElement($element);
        $this->elements['to_group'] = $element;
    }

    /**
     *
     */
    protected function initToEscalationElement()
    {
        $element = new \Zend_Form_Element_Checkbox('to_escalation');
        $element->setLabel($this->getTranslator()->_('ToEscalation'));
        $element->addValidator($this->validator->getFor('to_escalation'));
        $element->addFilter($this->filter->getFor('to_escalation'));
        $element->setRequired(true);
        $this->addElement($element);
        $this->elements['to_escalation'] = $element;
    }

}
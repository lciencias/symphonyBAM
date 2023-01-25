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

use Application\Validator\PersonValidator;
use Application\Filter\PersonFilter;

use \Zend_Form_Element_Text as ElementText;

/**
 *
 * PersonForm
 * @author chente
 *
 */
class PersonForm extends BaseForm{

    /**
     * init
     */
    public function init()
    {
        parent::init();
        $this->validator = new PersonValidator();
        $this->filter = new PersonFilter();

        $this->initNameElement();
        $this->initLastNameElement();
        $this->initMiddleNameElement();
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
    protected function initLastNameElement()
    {
        $element = new ElementText('last_name');
        $element->setLabel($this->getTranslator()->_('LastName'));
        $element->addValidator($this->validator->getFor('last_name'));
        $element->addFilter($this->filter->getFor('last_name'));
        $element->setRequired(true);
        $this->addElement($element);
        $this->elements['last_name'] = $element;
    }

    /**
     *
     */
    protected function initMiddleNameElement()
    {
        $element = new ElementText('middle_name');
        $element->setLabel($this->getTranslator()->_('MiddleName'));
        $element->addValidator($this->validator->getFor('middle_name'));
        $element->addFilter($this->filter->getFor('middle_name'));
        $this->addElement($element);
        $this->elements['middle_name'] = $element;
    }

    /**
     *
     */
    protected function initCurpElement()
    {
        $element = new ElementText('curp');
        $element->setLabel($this->getTranslator()->_('Curp'));
        $element->addValidator($this->validator->getFor('curp'));
        $element->addFilter($this->filter->getFor('curp'));
        $this->addElement($element);
        $this->elements['curp'] = $element;
    }

}
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

use Application\Validator\CompanyValidator;
use Application\Filter\CompanyFilter;

use \Zend_Form_Element_Text as ElementText;

/**
 *
 * CompanyForm
 * @author chente
 *
 */
class CompanyForm extends BaseForm{

    /**
     * init
     */
    public function init()
    {
        parent::init();
        $this->validator = new CompanyValidator();
        $this->filter = new CompanyFilter();

        $this->initNameElement();
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

}
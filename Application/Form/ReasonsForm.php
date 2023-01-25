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

use Application\Validator\ReasonsValidator;
use Application\Filter\ReasonsFilter;

use \Zend_Form_Element_Text as ElementText;

/**
 *
 * ChannelForm
 * @author chente
 *
 */
class ReasonsForm extends BaseForm{

    /**
     * init
     */
    public function init()
    {
        parent::init();
        $this->validator = new ReasonsValidator();
        $this->filter = new ReasonsFilter();

        $this->initNameElement();
        $this->initStatusElement();
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
    protected function initStatusElement()
    {
        $element = new \Zend_Form_Element_Hidden('status');
        $option = 1;
        $element->setValue($option);
        $this->addElement($element);
        $this->elements['status'] = $element;
    }

}
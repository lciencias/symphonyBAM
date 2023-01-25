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

use Application\Validator\ServiceLevelValidator;
use Application\Filter\ServiceLevelFilter;

use \Zend_Form_Element_Text as ElementText;

/**
 *
 * ServiceLevelForm
 * @author chente
 *
 */
class ServiceLevelForm extends BaseForm{

    /**
     * init
     */
    public function init()
    {
        parent::init();
        $this->validator = new ServiceLevelValidator();
        $this->filter = new ServiceLevelFilter();

        $this->initNameElement();
        $this->addElement(new ElementText('slider_resolution_time'));
        $this->addElement(new ElementText('slider_response_time'));
        $this->initNoteElement();
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
    protected function initResolutionTimeElement()
    {
        $element = new \Zend_Form_Element_Hidden('resolution_time');
        $element->setAttrib('size', '1');
        $element->setLabel($this->getTranslator()->_('Resolution Time'));
        $element->addValidator($this->validator->getFor('resolution_time'));
        $element->addFilter($this->filter->getFor('resolution_time'));
        $element->setRequired(true);
        $element->getValue();
        $this->addElement($element);
        $this->elements['resolution_time'] = $element;
    }

    /**
     *
     */
    protected function initResponseTimeElement()
    {
        $element = new \Zend_Form_Element_Hidden('response_time');
        $element->setAttrib('size', '1');
        $element->addValidator($this->validator->getFor('response_time'));
        $element->addFilter($this->filter->getFor('response_time'));
        $element->setRequired(true);
        $this->addElement($element);
        $this->elements['response_time'] = $element;
    }

    /**
     *
     */
    protected function initNoteElement()
    {
        $element = new  \Zend_Form_Element_Textarea('note');
        $element->setAttrib('cols', '25');
        $element->setAttrib('rows', '5');
        $element->setLabel($this->getTranslator()->_('Note'));
        $element->addValidator($this->validator->getFor('note'));
        $element->addFilter($this->filter->getFor('note'));
        $this->addElement($element);
        $this->elements['note'] = $element;
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
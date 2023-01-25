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

use Application\Validator\ActivityValidator;
use Application\Filter\ActivityFilter;

use \Zend_Form_Element_Text as ElementText;

/**
 *
 * ActivityForm
 * @author chente
 *
 */
class ActivityForm extends BaseForm{

    /**
     * init
     */
    public function init()
    {
        parent::init();
        $this->validator = new ActivityValidator();
        $this->filter = new ActivityFilter();

        $this->initIdUserElement();
        $this->initIdTicketElement();
        $this->initStartDateElement();
        $this->initEndDateElement();
        $this->initNoteElement();
    }


    /**
     *
     */
    protected function initIdUserElement()
    {
        $element = new \Zend_Form_Element_Select('id_user');
        $options = \Application\Query\UserQuery::create()->find()->toCombo();
        $element->addMultiOptions($options);
        $element->setLabel($this->getTranslator()->_('IdUser'));
        $element->addValidator($this->validator->getFor('id_user'));
        $element->addFilter($this->filter->getFor('id_user'));
        $element->setRequired(true);
        $this->addElement($element);
        $this->elements['id_user'] = $element;
    }

    /**
     *
     */
    protected function initIdTicketElement()
    {
        $element = new \Zend_Form_Element_Select('id_ticket');
        $options = \Application\Query\TicketQuery::create()->find()->toCombo();
        $element->addMultiOptions($options);
        $element->setLabel($this->getTranslator()->_('IdTicket'));
        $element->addValidator($this->validator->getFor('id_ticket'));
        $element->addFilter($this->filter->getFor('id_ticket'));
        $element->setRequired(true);
        $this->addElement($element);
        $this->elements['id_ticket'] = $element;
    }

    /**
     *
     */
    protected function initStartDateElement()
    {
        $element = new ElementText('start_date');
        $element->setAttrib('class', 'datepicker');
        $element->setLabel($this->getTranslator()->_('StartDate'));
        $element->addValidator($this->validator->getFor('start_date'));
        $element->addFilter($this->filter->getFor('start_date'));
        $element->setRequired(true);
        $this->addElement($element);
        $this->elements['start_date'] = $element;
    }

    /**
     *
     */
    protected function initEndDateElement()
    {
        $element = new ElementText('end_date');
        $element->setAttrib('class', 'datepicker');
        $element->setLabel($this->getTranslator()->_('EndDate'));
        $element->addValidator($this->validator->getFor('end_date'));
        $element->addFilter($this->filter->getFor('end_date'));
        $this->addElement($element);
        $this->elements['end_date'] = $element;
    }

    /**
     *
     */
    protected function initNoteElement()
    {
        $element = new ElementText('note');
        $element->setLabel($this->getTranslator()->_('Note'));
        $element->addValidator($this->validator->getFor('note'));
        $element->addFilter($this->filter->getFor('note'));
        $element->setRequired(true);
        $this->addElement($element);
        $this->elements['note'] = $element;
    }

}
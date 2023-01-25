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

use Application\Validator\CalendarValidator;
use Application\Filter\CalendarFilter;

use \Zend_Form_Element_Text as ElementText;

/**
 *
 * CalendarForm
 * @author chente
 *
 */
class CalendarForm extends BaseForm{

    /**
     * init
     */
    public function init()
    {
        parent::init();
        $this->validator = new CalendarValidator();
        $this->filter = new CalendarFilter();

        $this->initDateElement();
        $this->initNameHolidayElement();
    }


    /**
     *
     */
    protected function initDateElement()
    {
        $element = new ElementText('date');
        $element->setAttrib('class', 'datepicker');
        $element->setLabel($this->getTranslator()->_('Date'));
        $element->addValidator($this->validator->getFor('date'));
        $element->addFilter($this->filter->getFor('date'));
        $element->setRequired(true);
        $this->addElement($element);
        $this->elements['date'] = $element;
    }


    /**
     *
     */
    protected function initNameHolidayElement()
    {
        $element = new ElementText('name_holiday');
        $element->setLabel($this->getTranslator()->_('Holiday'));
        $element->addValidator($this->validator->getFor('name_holiday'));
        $element->addFilter($this->filter->getFor('name_holiday'));
        $element->setRequired(true);
        $this->addElement($element);
        $this->elements['name_holiday'] = $element;
    }

}
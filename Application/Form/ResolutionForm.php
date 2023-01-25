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

use Application\Model\Bean\Resolution;

use Application\Validator\ResolutionValidator;
use Application\Filter\ResolutionFilter;

use \Zend_Form_Element_Text as ElementText;

/**
 *
 * ResolutionForm
 * @author chente
 *
 */
class ResolutionForm extends BaseForm{

    /**
     * init
     */
    public function init()
    {
        parent::init();
        $this->validator = new ResolutionValidator();
        $this->filter = new ResolutionFilter();

        $this->initNameElement();
        $this->initTypeElement();
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
    protected function initTypeElement()
    {
        $i18n = $this->getTranslator();
        $options = array_map(function ($item) use($i18n){
            return $i18n->_($item);
        }, array_flip(Resolution::$Types));

        $element = new \Zend_Form_Element_Select('type');
        $element->addMultiOptions($options);
        $element->setLabel($this->getTranslator()->_('Type'));
        $element->addValidator($this->validator->getFor('type'));
        $element->addFilter($this->filter->getFor('type'));
        $element->setRequired(true);
        $element->setAttribs(array('class' => 'span4'));
        $this->addElement($element);
        $this->elements['type'] = $element;
    }

}
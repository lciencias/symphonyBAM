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

use Application\Validator\CustomizeValidator;
use Application\Filter\CustomizeFilter;

use \Zend_Form_Element_Text as ElementText;

/**
 *
 * CustomizeForm
 * @author chente
 *
 */
class CustomizeForm extends BaseForm{

    /**
     * init
     */
    public function init()
    {
        parent::init();
        $this->validator = new CustomizeValidator();
        $this->filter = new CustomizeFilter();


        $this->initIdCompanyElement();
        $this->initLogoElement();
        $this->initBackgroundColorElement();
        $this->initForwardColorElement();
        $this->initFontSizeElement();
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
        $this->addElement($element);
        $this->elements['id_company'] = $element;
    }

    /**
     *
     */
    protected function initLogoElement()
    {
        $element = new ElementText('logo');
        $element->setLabel($this->getTranslator()->_('Logo'));
        $element->addValidator($this->validator->getFor('logo'));
        $element->addFilter($this->filter->getFor('logo'));
        $element->setRequired(true);
        $this->addElement($element);
        $this->elements['logo'] = $element;
    }

    /**
     *
     */
    protected function initBackgroundColorElement()
    {
        $element = new ElementText('background_color');
        $element->setLabel($this->getTranslator()->_('BackgroundColor'));
        $element->setAttrib('class', 'colorPicker');
        $element->addValidator($this->validator->getFor('background_color'));
        $element->addFilter($this->filter->getFor('background_color'));
        $this->addElement($element);
        $this->elements['background_color'] = $element;
    }

    /**
     *
     */
    protected function initForwardColorElement()
    {
        $element = new ElementText('forward_color');
        $element->setLabel($this->getTranslator()->_('ForwardColor'));
        $element->setAttrib('class', 'colorPicker');
        $element->addValidator($this->validator->getFor('forward_color'));
        $element->addFilter($this->filter->getFor('forward_color'));
        $this->addElement($element);
        $this->elements['forward_color'] = $element;
    }

    /**
     *
     */
    protected function initFontSizeElement()
    {
        $element = new ElementText('font_size');
        $element->setLabel($this->getTranslator()->_('FontSize'));
        $element->addValidator($this->validator->getFor('font_size'));
        $element->addFilter($this->filter->getFor('font_size'));
        $this->addElement($element);
        $this->elements['font_size'] = $element;
    }

}
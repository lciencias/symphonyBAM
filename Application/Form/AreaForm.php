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

use Application\Model\Bean\Area;

use Application\Validator\AreaValidator;
use Application\Filter\AreaFilter;

use \Zend_Form_Element_Text as ElementText;

/**
 *
 * AreaForm
 * @author chente
 *
 */
class AreaForm extends BaseForm
{
    /**
     *
     * @var Area
     */
    protected $area;

    /**
     *
     */
    public function setArea($area){
        $this->area = $area;
    }

    /**
     * init
     */
    public function init()
    {
        parent::init();
        $this->validator = new AreaValidator();
        $this->filter = new AreaFilter();

        $this->initIdCompanyElement();
        $this->initNameElement();
        $this->initStatusElement();
    }


    /**
     *
     */
    protected function initIdCompanyElement()
    {
        $element = new \Zend_Form_Element_Select('id_company');

        $element->setLabel($this->getTranslator()->_('Company'));
        $element->addValidator($this->validator->getFor('id_company'));
        $element->addFilter($this->filter->getFor('id_company'));

        $element->setAttribs(array('class' => 'span4'));
        if( $this->area instanceof Area ){
            $options = \Application\Query\CompanyQuery::create()
                ->pk($this->area->getIdCompany())
                ->find()->toCombo();
            $element->setAttrib('disabled', 'disabled');

        }else{
            $options = \Application\Query\CompanyQuery::create()->find()->actives()->toCombo();
            $element->setRequired(true);
        }
        $element->addMultiOptions($options);
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
    protected function initStatusElement()
    {
        $element = new \Zend_Form_Element_Hidden('status');
        $option = 1;
        $element->setValue($option);
        $this->addElement($element);
        $this->elements['status'] = $element;
    }

}
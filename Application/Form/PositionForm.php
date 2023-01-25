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

use Application\Model\Bean\Position;

use Application\Validator\PositionValidator;
use Application\Filter\PositionFilter;

use \Zend_Form_Element_Text as ElementText;

/**
 *
 * PositionForm
 * @author chente
 *
 */
class PositionForm extends BaseForm
{
    /**
     *
     * @var Position
     */
    protected $position;

    /**
     *
     * @param Position $position
     */
    public function setPosition($position){
        $this->position = $position;
    }

    /**
     * init
     */
    public function init()
    {
        parent::init();
        $this->validator = new PositionValidator();
        $this->filter = new PositionFilter();

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

        if( $this->position instanceof Position ){
            $options = \Application\Query\CompanyQuery::create()
                ->pk($this->position->getIdCompany())->find()->toCombo();
            $element->setAttrib('disabled', 'disabled');
        }else{
            $options = \Application\Query\CompanyQuery::create()->actives()->find()->toCombo();
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
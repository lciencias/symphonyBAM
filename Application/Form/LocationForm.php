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

use Application\Model\Bean\Location;

use Application\Validator\LocationValidator;
use Application\Filter\LocationFilter;

use \Zend_Form_Element_Text as ElementText;

/**
 *
 * LocationForm
 * @author chente
 *
 */
class LocationForm extends BaseForm{

    /**
     *
     * @var Location
     */
    protected $location;

    /**
     *
     * @param Location $location
     */
    public function setLocation($location){
        $this->location = $location;
    }

    /**
     * init
     */
    public function init()
    {
        parent::init();
        $this->validator = new LocationValidator();
        $this->filter = new LocationFilter();

        $this->initIdCompanyElement();
        $this->initNameElement();
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
        if( $this->location instanceof Location ){
            $options = \Application\Query\CompanyQuery::create()->pk($this->location->getIdCompany())
                ->find()->actives()->toCombo();
            $element->setAttribs(array('disabled' => 'disabled'));
        }else{
            $options = \Application\Query\CompanyQuery::create()->find()->actives()->toCombo();
            $element->setRequired(true);
        }
        $element->addMultiOptions($options);
        $element->setAttribs(array('class' => 'span4'));
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

}
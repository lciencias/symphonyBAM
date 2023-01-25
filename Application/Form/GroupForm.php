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

use Application\Model\Bean\Group;
use Application\Validator\GroupValidator;
use Application\Filter\GroupFilter;
use \Zend_Form_Element_Text as ElementText;

/**
 *
 * GroupForm
 * @author chente
 *
 */
class GroupForm extends BaseForm
{

    /**
     *
     * @var Group
     */
    protected $group;

    /**
     *
     * @param Group $group
     */
    public function setGroup($group){
        $this->group = $group;
    }

    /**
     * init
     */
    public function init()
    {
        parent::init();
        $this->validator = new GroupValidator();
        $this->filter = new GroupFilter();

        $this->initNameElement();
        $this->initIdUserElement();
        $this->initIdWorkweekElement();
        $this->initStatusElement();
    }


    /**
     *
     */
    protected function initIdUserElement()
    {
        $element = new \Zend_Form_Element_Select('id_user');
        $options = \Application\Query\UserQuery::create()->actives()->find();
        $element->setLabel($this->getTranslator()->_('Responsable'));
        $element->addValidator($this->validator->getFor('id_user'));
        $element->addFilter($this->filter->getFor('id_user'));
        $element->setRequired(true);
        $element->setAttribs(array('class' => 'span4'));

        if( $this->group instanceof Group && !$options->containsIndex($this->group->getIdUser()) ){
            $options = $options->merge(
                \Application\Query\UserQuery::create()->pk($this->group->getIdUser())->find()
            );
        }

        $element->addMultiOptions($options->toCombo());

        $this->addElement($element);
        $this->elements['id_user'] = $element;
    }

    /**
     *
     */
    protected function initIdWorkweekElement()
    {
        $element = new \Zend_Form_Element_Select('id_workweek');

        $element->setLabel($this->getTranslator()->_("Schedule"));
        $element->addValidator($this->validator->getFor('id_workweek'));
        $element->addFilter($this->filter->getFor('id_workweek'));
        $element->setRequired(true);
        $element->setAttribs(array('class' => 'span4'));

        $options = \Application\Query\WorkweekQuery::create()->actives()->find();
        if( $this->group instanceof Group && !$options->containsIndex($this->group->getIdWorkweek())){
            $options = $options->merge(\Application\Query\WorkweekQuery::create()
                ->pk($this->group->getIdWorkweek())->find()
            );
        }

        $element->addMultiOptions($options->toCombo());

        $this->addElement($element);
        $this->elements['id_workweek'] = $element;
    }

    /**
     *
     */
    protected function initNameElement()
    {
        $element = new ElementText('name');
        $element->setLabel($this->getTranslator()->_('Group'));
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
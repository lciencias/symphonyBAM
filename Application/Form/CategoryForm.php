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

use Application\Model\Bean\Category;
use Application\Validator\CategoryValidator;
use Application\Filter\CategoryFilter;
use Application\Query\EscalationQuery;
use Application\Query\GroupQuery;
use Application\Query\ServiceLevelQuery;
use \Zend_Form_Element_Text as ElementText;

/**
 *
 * CategoryForm
 * @author chente
 *
 */
class CategoryForm extends BaseForm
{
    /**
     *
     * @var Category
     */
    private $category;

    /**
     *
     * @param Category $category
     */
    public function setCategory(Category $category){
        $this->category = $category;
    }

    /**
     *
     * @return Category
     */
    public function getCategory(){
        return $this->category;
    }

    /**
     *
     * @return boolean
     */
    public function hasCategory(){
        return $this->category instanceof Category;
    }

    /**
     * init
     */
    public function init()
    {
        parent::init();
        $this->validator = new CategoryValidator();
        $this->filter = new CategoryFilter();

        $this->initNameElement();
        $this->initIdCompanyElement();
        $this->initIdParentElement();
        $this->initIdEscalationElement();
        $this->initIdGroupElement();
        $this->initIdServiceLevelElement();
        $this->initNoteElement();
    }


    /**
     *
     */
    protected function initIdParentElement()
    {
        $element = new \Zend_Form_Element_Hidden('id_parent');
        $element->setValue(null);
        $element->addValidator($this->validator->getFor('id_parent'));
        $element->addFilter($this->filter->getFor('id_parent'));
        $this->addElement($element);
        $this->elements['id_parent'] = $element;
    }

    /**
     *
     * @param int $idParent
     */
    public function setIdParent($idParent){
        $this->elements['id_parent']->setValue($idParent);
    }

    /**
     *
     * @param int $idParent
     */
    public function setIdCompany($idCompany){
        $this->elements['id_company']->setValue($idCompany);
    }

    /**
     *
     */
    protected function initIdCompanyElement()
    {
        $element = new \Zend_Form_Element_Hidden('id_company');
        $element->addValidator($this->validator->getFor('id_company'));
        $element->addFilter($this->filter->getFor('id_company'));
        $element->setRequired(true);
        $this->addElement($element);
        $this->elements['id_company'] = $element;
    }

    /**
     *
     */
    protected function initIdEscalationElement()
    {
        $element = new \Zend_Form_Element_Select('id_escalation');

        $element->addMultiOptions($this->getEscalationCombo());
        $element->setLabel($this->getTranslator()->_('Escalation'));
        $element->addValidator($this->validator->getFor('id_escalation'));
        $element->addFilter($this->filter->getFor('id_escalation'));
        $element->setRequired(true);
        $element->setAttribs(array('class' => 'span4'));
        $this->addElement($element);
        $this->elements['id_escalation'] = $element;
    }

    /**
     *
     */
    protected function initIdGroupElement()
    {
        $element = new \Zend_Form_Element_Select('id_group');
        $element->addMultiOptions($this->getGroupCombo());
        $element->setLabel($this->getTranslator()->_('Group'));
        $element->addValidator($this->validator->getFor('id_group'));
        $element->addFilter($this->filter->getFor('id_group'));
        $element->setRequired(true);
        $element->setAttribs(array('class' => 'span4'));
        $this->addElement($element);
        $this->elements['id_group'] = $element;
    }

    /**
     *
     */
    protected function initIdServiceLevelElement()
    {
        $element = new \Zend_Form_Element_Select('id_service_level');
        $element->addMultiOptions($this->getServiceLevelCombo());
        $element->setLabel($this->getTranslator()->_('Service Level'));
        $element->addValidator($this->validator->getFor('id_service_level'));
        $element->addFilter($this->filter->getFor('id_service_level'));
        $element->setRequired(true);
        $element->setAttribs(array('class' => 'span4'));
        $this->addElement($element);
        $this->elements['id_service_level'] = $element;
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
    protected function initNoteElement()
    {
        $element = new \Zend_Form_Element_Textarea('note');
        $element->setLabel($this->getTranslator()->_('Note'));
        $element->addValidator($this->validator->getFor('note'));
        $element->setAttribs(array('cols' => 30, 'rows' => 5));
        $element->addFilter($this->filter->getFor('note'));
        $this->addElement($element);
        $this->elements['note'] = $element;
    }

    /**
     * @return array
     */
    private function getEscalationCombo(){
        $q = EscalationQuery::create();

        if( $this->hasCategory() ){
            $q->where()->setOR();
            $q->pk($this->getCategory()->getIdEscalation());
            $q->where()->setAND();
        }

        return $q->actives()->find()->toCombo();
    }

    /**
     * @return array
     */
    private function getGroupCombo(){
        $q = GroupQuery::create();

        if( $this->hasCategory() ){
            $q->where()->setOR();
            $q->pk($this->getCategory()->getIdGroup());
            $q->where()->setAND();
        }

        return $q->actives()->find()->toCombo();
    }

    /**
     * @return array
     */
    private function getServiceLevelCombo(){
        $q = ServiceLevelQuery::create();

        if( $this->hasCategory() ){
            $q->where()->setOR();
            $q->pk($this->getCategory()->getIdServiceLevel());
            $q->where()->setAND();
        }

        return $q->actives()->find()->toCombo();
    }

}
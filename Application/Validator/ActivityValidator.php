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

namespace Application\Validator;


use Zend_Validate as ZendValidator;

/**
 *
 * ActivityValidator
 * @author chente
 *
 */
class ActivityValidator extends BaseValidator{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->initIdActivityValidator();
        $this->initIdUserValidator();
        $this->initIdTicketValidator();
        $this->initStartDateValidator();
        $this->initEndDateValidator();
        $this->initNoteValidator();
    }

    /**
     *
     */
    protected function initIdActivityValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getDigits());
        $this->elements['id_activity'] = $validator;
    }

    /**
     *
     */
    protected function initIdUserValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getDigits());
        $this->elements['id_user'] = $validator;
    }

    /**
     *
     */
    protected function initIdTicketValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getDigits());
        $this->elements['id_ticket'] = $validator;
    }

    /**
     *
     */
    protected function initStartDateValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getDatetimeMysql());
        $this->elements['start_date'] = $validator;
    }

    /**
     *
     */
    protected function initEndDateValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getDatetimeMysql());
        $this->elements['end_date'] = $validator;
    }

    /**
     *
     */
    protected function initNoteValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getAlnumSpaces());
        $this->elements['note'] = $validator;
    }

 }

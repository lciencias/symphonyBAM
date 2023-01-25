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
 * ChannelValidator
 * @author chente
 *
 */
class ChannelValidator extends BaseValidator{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->initIdChannelValidator();
        $this->initNameValidator();
        $this->initStatusValidator();
    }

    /**
     *
     */
    protected function initIdChannelValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getDigits());
        $this->elements['id_channel'] = $validator;
    }

    /**
     *
     */
    protected function initNameValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getAlnumSpaces());
        $this->elements['name'] = $validator;
    }

    /**
     *
     */
    protected function initStatusValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getDigits());
        $this->elements['status'] = $validator;
    }

 }

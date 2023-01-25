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
class ReasonsValidator extends BaseValidator{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->initIdReasonValidator();
        $this->initNameValidator();
        $this->initStatusValidator();
    }

    /**
     *
     */
    protected function initIdReasonValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getDigits());
        $this->elements['id_reason'] = $validator;
    }

    /**
     *
     */
    protected function initNameValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getAlnumSpaces());
//        echo "<pre>";
//                var_dump($validator);

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

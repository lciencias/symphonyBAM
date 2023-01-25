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
 * CalendarValidator
 * @author chente
 *
 */
class CalendarValidator extends BaseValidator{

    /**
     * Construct
     */
    public function __construct()
    {
        parent::__construct();
        $this->initIdCalendarValidator();
        $this->initDateValidator();
        $this->initIsWeekendValidator();
        $this->initIsHolidayValidator();
        $this->initNameHolidayValidator();
    }

    /**
     *
     */
    protected function initIdCalendarValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getDigits());
        $this->elements['id_calendar'] = $validator;
    }

    /**
     *
     */
    protected function initDateValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $validator->addValidator($this->getDateMysql());
        $this->elements['date'] = $validator;
    }

    /**
     *
     */
    protected function initIsWeekendValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $this->elements['is_weekend'] = $validator;
    }

    /**
     *
     */
    protected function initIsHolidayValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getNotEmpty());
        $this->elements['is_holiday'] = $validator;
    }

    /**
     *
     */
    protected function initNameHolidayValidator()
    {
        $validator = new ZendValidator();
        $validator->addValidator($this->getAlnumSpaces());
        $this->elements['name_holiday'] = $validator;
    }

 }

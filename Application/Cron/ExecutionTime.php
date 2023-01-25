<?php
/**
 * PCS Mexico
 *
 * Sistema de Distribucion
 *
 * @category   project
 * @package    Project_Reports
 * @copyright  Copyright (c) 2007-2008 PCS Mexico (http://www.pcsmexico.com)
 * @author     chente
 * @version    1.0
 */


namespace Application\Cron;

/**
 * Clase para generar los menus del sistema
 *
 * @category   project
 * @package    Project_Reports
 * @copyright  Copyright (c) 2007-2008 PCS Mexico (http://www.pcsmexico.com)
 */
class ExecutionTime
{

    /**
     *
     *
     * @var Zend_Date
     */
    protected $now;

    /**
     *
     *
     * @var Zend_Date
     */
    protected $nowPlus5;

    /**
     *
     * @var array
     */
    protected $dates = array();

    /**
     *
     * construct
     */
    public function __construct(\Zend_Date $now, \Zend_Date $nowPlus5)
    {
        $this->now = clone $now;
        $this->nowPlus5 = clone $nowPlus5;
    }

    /**
     *
     * Enter description here ...
     * @param unknown_type $time
     * @param unknown_type $format
     * @return ExecutionTime
     * @throws Exception
     */
    public function addTime($time, $format = 'HH:mm:ss')
    {
        if( !\Zend_Date::isDate($time, $format) )
            throw new \Exception('time invalid '. $time);

        $date = new \Zend_Date();
        $date->set($time, $format);
        $this->dates[] = $date;

        return $this;
    }

    /**
     *
     * @param int $hours
     * @return ExecutionTime
     */
    public function addEveryHours($hours)
    {
        if( !is_numeric($hours) ){
            throw new Exception("Las horas tienen que ser un dato entero");
        }

        if( $hours >= 24  || $hours <= 0 ){
            throw new Exception("Las horas tienen que ser un valor valido de 1 a 23 horas");
        }

        $hour = 0;
        while ( $hour < 24 ) {
            if( strlen($hour) == 1 ){
                $strTime = "0{$hour}:04:00";
            }else{
                $strTime = "{$hour}:04:00";
            }
            $hour += $hours;
            $this->addTime($strTime);
        }

        return $this;
    }

    /**
     *
     * @param int $hours
     * @return ExecutionTime
     */
    public function addEveryMinutes($minutes)
    {
        if( !is_numeric($minutes) ){
            throw new \Exception("Los minutos tienen que ser un dato entero");
        }

        if( $minutes >= 60  || $minutes < 5 ){
            throw new \Exception("Los minutos tienen que ser un valor valido de 5 a 60 minutos");
        }

        $minute = 4;
        while ( $minute < 1440 ) {

            $hour = floor($minute / 60);
            $min = $minute - ( $hour * 60 );

            $hour = str_pad($hour, 2, '0', STR_PAD_LEFT);
            $min = str_pad($min, 2, '0', STR_PAD_LEFT);

            $strTime = "{$hour}:{$min}:04";
            $this->addTime($strTime);

            $minute += $minutes;
        }

        return $this;
    }

    /**
     *
     * @return boolean
     */
    public function isTime()
    {
        foreach ($this->dates as $date){
            /** @var \Zend_Date $date */
            if( $date->isLater($this->getNow()->get('HH:mm:ss'), 'HH:mm:ss')
            &&  $date->isEarlier($this->getNowPlus5()->get('HH:mm:ss'), 'HH:mm:ss') ){
                return true;
            }
        }
        return false;
    }

    /**
     * @return Zend_Date
     */
    public function getNow() {
        return $this->now;
    }

    /**
     * @return Zend_Date
     */
    public function getNowPlus5() {
        return $this->nowPlus5;
    }
}

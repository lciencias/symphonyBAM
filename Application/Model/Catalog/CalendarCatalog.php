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

namespace Application\Model\Catalog;

use Application\Model\Catalog\AbstractCatalog;
use Application\Model\Bean\Calendar;
use Application\Model\Factory\CalendarFactory;
use Application\Model\Collection\CalendarCollection;
use Application\Model\Exception\CalendarException;
use Application\Model\Bean\Bean;
use Application\Query\CalendarQuery;
use Query\Query;

/**
 *
 * CalendarCatalog
 *
 * @package Application\Model\Catalog
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Calendar getOneByQuery() getOneByQuery(Query $query, Storage $storage = null)
 * @method \Application\Model\Collection\CalendarCollection getByQuery() getByQuery(Query $query, Storage $storage = null)
 */
class CalendarCatalog extends AbstractCatalog {

    /**
     * Metodo para agregar un Calendar a la base de datos
     * @param Calendar $calendar Objeto Calendar
     */
    public function create($calendar)
    {
        $this->validateBean($calendar);
        try
        {
            $data = $calendar->toArrayFor(
                array('date', 'is_weekend', 'is_holiday', 'name_holiday', 'day_number')
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->insert(Calendar::TABLENAME, $data);
            $calendar->setIdCalendar($this->getDb()->lastInsertId());
        }
        catch(\Exception $e)
        {
            $this->throwException("The Calendar can't be saved \n", $e);
        }
    }

    /**
     * Metodo para actualizar un Calendar en la base de datos
     * @param Calendar $calendar Objeto Calendar
     */
    public function update($calendar)
    {
        $this->validateBean($calendar);
        try
        {
            $data = $calendar->toArrayFor(
                array('date', 'is_weekend', 'is_holiday', 'name_holiday', 'day_number')
            );
            $data = array_filter($data, array($this, 'isNotNull'));
            $this->getDb()->update(Calendar::TABLENAME, $data, "id_calendar = '{$calendar->getIdCalendar()}'");
        }
        catch(\Exception $e)
        {
            $this->throwException("The Calendar can't be saved \n", $e);
        }
    }

    /**
     * Metodo para eliminar un Calendar a partir de su Id
     * @param int $idCalendar
     */
    public function deleteById($idCalendar)
    {
        try
        {
            $where = array($this->getDb()->quoteInto('id_calendar = ?', $idCalendar));
            $this->getDb()->delete(Calendar::TABLENAME, $where);
        }
        catch(\Exception $e)
        {
            $this->throwException("The Calendar can't be deleted\n", $e);
        }
    }


    /**
     *
     * makeCollection
     * @return \Application\Model\Collection\CalendarCollection
     */
    protected function makeCollection(){
        return new CalendarCollection();
    }

    /**
     *
     * makeBean
     * @param array $resultset
     * @return \Application\Model\Bean\Calendar
     */
    protected function makeBean($resultset){
        return CalendarFactory::createFromArray($resultset);
    }

    /**
     *
     * Validate Query
     * @param CalendarQuery $query
     * @throws RoundException
     */
    protected function validateQuery(Query $query)
    {
        if( !($query instanceof CalendarQuery) ){
            $this->throwException("No es un Query valido");
        }
    }

    /**
     *
     * Validate Calendar
     * @param Calendar $calendar
     * @throws Exception
     */
    protected function validateBean($calendar = null){
        if( !($calendar instanceof Calendar) ){
            $this->throwException("passed parameter isn't a Calendar instance");
        }
    }

    /**
     *
     * throwException
     * @throws Exception
     */
    protected function throwException($message, \Exception $exception = null){
        if( null != $exception){
            throw new CalendarException("$message ". $exception->getMessage(), 500, $exception);
        }else{
            throw new CalendarException($message);
        }
    }

 }
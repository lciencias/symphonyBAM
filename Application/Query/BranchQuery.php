<?php
/**
 * PCS Mexico
 *
 * Symphony BAM
 *
 * @copyright Copyright (c) PCS Mexico (http://www.pcsmexico.com)
 * @author    jose luis, $LastChangedBy$
 * @version   2
 */

namespace Application\Query;

use Query\Query;
use Application\Model\Catalog\BranchCatalog;
use Application\Model\Bean\Branch;

use Application\Query\BaseQuery;

/**
 * Application\Query\BranchQuery
 *
 * @method \Application\Query\BranchQuery pk() pk(int $primaryKey)
 * @method \Application\Query\BranchQuery useMemoryCache()
 * @method \Application\Query\BranchQuery useFileCache()
 * @method \Application\Model\Collection\BranchCollection find()
 * @method \Application\Model\Bean\Branch findOne()
 * @method \Application\Model\Bean\Branch findOneOrElse() findOneOrElse(Branch $alternative)
 * @method \Application\Model\Bean\Branch findOneOrThrow() findOneOrThrow($message)
 * @method \Application\Model\Bean\Branch findByPK() findByPK($pk)
 * @method \Application\Model\Bean\Branch findByPKOrElse() findByPKOrElse($pk, Branch $alternative)
 * @method \Application\Model\Bean\Branch findByPKOrThrow() findByPKOrThrow($pk, $message)
 * @method \Application\Query\BranchQuery create() create(QuoteStrategy $quoteStrategy = null)
 * @method \Query\Criteria joinOn() joinOn($table, $type = null, $alias = null)
 * @method \Application\Query\BranchQuery joinUsing() joinUsing($table, $usingColumn, $type = null, $alias = null)
 * @method \Query\Criteria innerJoinOn() innerJoinOn($table, $alias = null)
 * @method \Application\Query\BranchQuery innerJoinUsing() innerJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria leftJoinOn() leftJoinOn($table, $alias = null)
 * @method \Application\Query\BranchQuery leftJoinUsing() leftJoinUsing($table, $usingColumn, $alias = null)
 * @method \Query\Criteria rigthJoinOn() rigthJoinOn($table, $alias = null)
 * @method \Application\Query\BranchQuery rigthJoinUsing() rigthJoinUsing($table, $usingColumn, $alias = null)
 * @method \Application\Query\BranchQuery removeJoins()
 * @method \Application\Query\BranchQuery removeJoin() removeJoin($table)
 * @method \Application\Query\BranchQuery from() from($table, $alias = null)
 * @method \Application\Query\BranchQuery removeFrom() removeFrom($from = null)
 * @method \Query\Criteria where()
 * @method \Query\Criteria having()
 * @method \Application\Query\BranchQuery whereAdd() whereAdd($column, $value, $comparison = null, $mutatorColumn = null, $mutatorValue = null)
 * @method \Application\Query\BranchQuery bind() bind($parameters)
 * @method \Application\Query\BranchQuery setQuoteStrategy() setQuoteStrategy(QuoteStrategy $quoteStrategy)
 * @method \Application\Query\BranchQuery page() page($page, $itemsPerPage)
 * @method \Application\Query\BranchQuery setLimit() setLimit($limit)
 * @method \Application\Query\BranchQuery setOffset() setOffset($offset)
 * @method \Application\Query\BranchQuery removeColumn() removeColumn($column = null)
 * @method \Application\Query\BranchQuery distinct()
 * @method \Application\Query\BranchQuery select()
 * @method \Application\Query\BranchQuery addColumns() addColumns($columns)
 * @method \Application\Query\BranchQuery addColumn() addColumn($column, $alias = null, $mutator = null)
 * @method \Application\Query\BranchQuery addGroupBy() addGroupBy($groupBy)
 * @method \Application\Query\BranchQuery orderBy() orderBy($name, $type = null)
 * @method \Application\Query\BranchQuery intoOutfile() intoOutfile($filename, $terminated = ',', $enclosed = '"', $escaped = '\\\\', $linesTerminated ='\r\n')
 * @method \Application\Query\BranchQuery addAscendingOrderBy() addAscendingOrderBy($name)
 * @method \Application\Query\BranchQuery addDescendingOrderBy() addDescendingOrderBy($name)
 * @method \Application\Query\BranchQuery setDefaultColumn() setDefaultColumn($defaultColumn)
 */
class BranchQuery extends BaseQuery{

    /**
     *
     * @return \Application\Model\Catalog\BranchCatalog
     */
    protected function getCatalog(){
        return \Zend_Registry::getInstance()->get('container')->get('BranchCatalog');
    }

    /**
     * initialization
     */
    protected function init()
    {
        $this->from(Branch::TABLENAME, "Branch");

        $defaultColumn = array("Branch.*");
        $this->setDefaultColumn($defaultColumn);
    }

    /**
     * @param mixed $value
     * @return Application\Query\BranchQuery
     */
    public function pk($value){
        $this->filter(array(
            Branch::ID_BRANCH => $value,
        ));
        return $this;
    }

    /**
     * @return array
     */
    public function fetchIds(){
       $this->removeColumn()->addColumn(Branch::ID_BRANCH, 'ids');
       return $this->fetchCol();
    }

    /**
     * build fromArray
     * @param array $fields
     * @param string $prefix
     * @return Application\Query\BranchQuery
     */
    public function filter($fields, $prefix = 'Branch'){
        $this->build($this, $fields, $prefix);
        return $this;
    }

    /**
     * build fromArray
     * @param Query $query
     * @param array $fields
     * @param string $prefix
     */
    public static function build(Query $query, $fields, $prefix = 'Branch')
    {

        $criteria = $query->where();
        $criteria->prefix($prefix);

        if( isset($fields['id_branch']) && !empty($fields['id_branch']) ){
            $criteria->add(Branch::ID_BRANCH, $fields['id_branch']);
        }
        if( isset($fields['id_country_state']) && !empty($fields['id_country_state']) ){
            $criteria->add(Branch::ID_COUNTRY_STATE, $fields['id_country_state']);
        }
        if( isset($fields['name']) && !empty($fields['name']) ){
            $criteria->add(Branch::NAME, trim($fields['name']),  BranchQuery::LIKE);
        }
        if( isset($fields['status']) && !empty($fields['status']) ){
            $criteria->add(Branch::STATUS, $fields['status']);
        }
        if( isset($fields['id_bam']) && !empty($fields['id_bam']) ){
            $criteria->add(Branch::ID_BAM, $fields['id_bam']);
        }
        if( isset($fields['address']) && !empty($fields['address']) ){
            $criteria->add(Branch::ADDRESS, $fields['address']);
        }
        if( isset($fields['scheduled']) && !empty($fields['scheduled']) ){
            $criteria->add(Branch::SCHEDULED, $fields['scheduled']);
        }

        $criteria->endPrefix();
    }

    /**
     * 
     * @return Application\Query\BranchQuery
     */
	public function actives(){
		$this->whereAdd(Branch::STATUS, Branch::$Status['Active']);
		return $this;
	}
	/**
     * @param string $alias
     * @param string aliasForeignTable
     * @return Application\Query\BranchQuery
     */
    public function innerJoinCountryState($alias = 'Branch', $aliasForeignTable = 'CountryState')
    {
        $this->innerJoinOn(\Application\Model\Bean\CountryState::TABLENAME, $aliasForeignTable)
            ->equalFields(array($alias, 'id_country_state'), array($aliasForeignTable, 'id_country_state'));

        return $this;
    }


}
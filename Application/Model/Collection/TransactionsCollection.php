<?php
/**
 * CubeSoftware
 *
 * 
 *
 * @copyright 
 * @author    Luis Hernandez, $LastChangedBy$
 * @version   
 */

namespace Application\Model\Collection;

use Application\Model\Bean\Transactions;

/**
 *
 * TransactionsCollection
 *
 * @author Luis Hernandez
 * @method \Application\Model\Bean\Transactions current()
 * @method \Application\Model\Bean\Transactions read()
 * @method \Application\Model\Bean\Transactions getOne()
 * @method \Application\Model\Bean\Transactions getOneOrElse() getOneOrElse(Application\Model\Bean\Transactions $transactions)
 * @method \Application\Model\Bean\Transactions getByPK() getByPK($primaryKey)
 * @method \Application\Model\Bean\Transactions getByPKOrElse() getByPKOrElse($primaryKey, Application\Model\Bean\Transactions $transactions)
 * @method \Application\Model\Collection\TransactionsCollection intersect() intersect(\Application\Model\Collection\TransactionsCollection $collection)
 * @method \Application\Model\Collection\TransactionsCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\TransactionsCollection merge() merge(\Application\Model\Collection\TransactionsCollection $collection)
 * @method \Application\Model\Collection\TransactionsCollection diff() diff(\Application\Model\Collection\TransactionsCollection $collection)
 * @method \Application\Model\Collection\TransactionsCollection copy()
 */
class TransactionsCollection extends Collection{

    /**
     *
     * @param Transactions $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Transactions) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Transactions");
        }
    }

    public function toArrayForList(){
    	return $this->map(function(Transactions $transactions){
    		return array($transactions->getIdTransaction() => $transactions->toArrayForList());
    	});
    }
    


}
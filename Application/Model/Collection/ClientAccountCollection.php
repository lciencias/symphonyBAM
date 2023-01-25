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

namespace Application\Model\Collection;

use EasyCSV\Exception;

use Application\Model\Bean\ClientAccount;

/**
 *
 * ClientAccountCollection
 *
 * @author jose luis
 * @method \Application\Model\Bean\ClientAccount current()
 * @method \Application\Model\Bean\ClientAccount read()
 * @method \Application\Model\Bean\ClientAccount getOne()
 * @method \Application\Model\Bean\ClientAccount getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\ClientAccountCollection intersect() intersect(\Application\Model\Collection\ClientAccountCollection $collection)
 * @method \Application\Model\Collection\ClientAccountCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\ClientAccountCollection merge() merge(\Application\Model\Collection\ClientAccountCollection $collection)
 * @method \Application\Model\Collection\ClientAccountCollection diff() diff(\Application\Model\Collection\ClientAccountCollection $collection)
 * @method \Application\Model\Collection\ClientAccountCollection copy()
 */
class ClientAccountCollection extends Collection{

    /**
     *
     * @param ClientAccount $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof ClientAccount) ){
            throw new \InvalidArgumentException("Debe de ser un objecto ClientAccount");
        }
    }
    /**
     * 
     * @param string $accountNumber
     * @return \Application\Model\Bean\ClientAccount
     */
	public function getByAccountNumber($accountNumber){
		$this->rewind();
		while ($clientAccount = $this->read()) {
			if ($clientAccount->getAccount() == $accountNumber) 
				$value = $clientAccount;
		}
		$this->rewind();
// 		if (!($value instanceof ClientAccount))
// 			throw new Exception('No es un ClientAccount');
		return $value;
	}

}
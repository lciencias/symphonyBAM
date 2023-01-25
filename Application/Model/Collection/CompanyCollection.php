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

namespace Application\Model\Collection;

use Application\Model\Bean\Company;

/**
 *
 * CompanyCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Company current()
 * @method \Application\Model\Bean\Company read()
 * @method \Application\Model\Bean\Company getOne()
 * @method \Application\Model\Bean\Company getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\CompanyCollection intersect() intersect(\Application\Model\Collection\CompanyCollection $collection)
 * @method \Application\Model\Collection\CompanyCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\CompanyCollection merge() merge(\Application\Model\Collection\CompanyCollection $collection)
 * @method \Application\Model\Collection\CompanyCollection diff() diff(\Application\Model\Collection\CompanyCollection $collection)
 * @method \Application\Model\Collection\CompanyCollection copy()
 */
class CompanyCollection extends Collection{

    /**
     *
     * @param Company $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Company) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Company");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(Company $company){
            return array( $company->getIdCompany() => $company->getName() );
        });
    }

    /**
     *
     * @return \Application\Model\Collection\CompanyCollection
     */
    public function actives(){
        return $this->filter(function(Company $company){
            return $company->isActive();
        });
    }

}
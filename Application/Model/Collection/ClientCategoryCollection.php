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

use Application\Model\Bean\ClientCategory;

/**
 *
 * ClientCategoryCollection
 *
 * @author jose luis
 * @method \Application\Model\Bean\ClientCategory current()
 * @method \Application\Model\Bean\ClientCategory read()
 * @method \Application\Model\Bean\ClientCategory getOne()
 * @method \Application\Model\Bean\ClientCategory getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\ClientCategoryCollection intersect() intersect(\Application\Model\Collection\ClientCategoryCollection $collection)
 * @method \Application\Model\Collection\ClientCategoryCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\ClientCategoryCollection merge() merge(\Application\Model\Collection\ClientCategoryCollection $collection)
 * @method \Application\Model\Collection\ClientCategoryCollection diff() diff(\Application\Model\Collection\ClientCategoryCollection $collection)
 * @method \Application\Model\Collection\ClientCategoryCollection copy()
 */
class ClientCategoryCollection extends Collection{

    /**
     *
     * @param ClientCategory $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof ClientCategory) ){
            throw new \InvalidArgumentException("Debe de ser un objecto ClientCategory");
        }
    }

    /**
     * @return array
     */
    public function toCombo($header = null){
    	$array = array();
    	if ($header)
    		$array[''] = $header;
        $array += $this->map(function(ClientCategory $clientCategory){
            return array( $clientCategory->getIdClientCategory() => $clientCategory->getName() );
        });
        return $array;
    }
    
    /**
     *
     * @return \Application\Model\Collection\CategoryCollection
     */
    public function filterRoot(){
    	return $this->filter(function (ClientCategory $category){
    		return $category->getIdParent() == null;
    	});
    }
    
    /**
     *
     * @param Category $category
     * @return \Application\Model\Collection\CategoryCollection
     */
    public function filterChildren(ClientCategory $category){
    	return $this->filter(function (ClientCategory $child) use($category){
    		return $child->getIdParent() == $category->getIdClientCategory();
    	});
    }
        
    /**
     * @return array
     */
    public function toComboConcat($header = false){
    	$array = array();
    	if ($header)
    		$array[''] = $header;
    		$array += $this->map(function(ClientCategory $reasons){
    			return array( $reasons->getIdClientCategory().'-'.(int)$reasons->getFinancialMovement().'-'.(int)$reasons->getPartialities() => $reasons->getName() );
    		});
    			return $array;
    }
    
    /**
     *
     * @return array
     */
    public function toNestedArray(ClientCategoryCollection $categories){
    	return $this->map(function (ClientCategory $category) use($categories){
    		$isLeaf = $category->getIsLeaf();
    		$isBranch = !$isLeaf;
    		return array(
    				$category->getIdClientCategory() => array(
    						'category' => $category,
    						'isLeaf' =>  $isLeaf,
    						'isBranch' => $isBranch,
    						'children' => $isBranch ? $categories->filterChildren($category)->toNestedArray($categories) : null,
    				));
    	});
    
    }
}
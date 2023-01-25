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

use Application\Model\Bean\Category;

/**
 *
 * CategoryCollection
 *
 * @author guadalupe, chente
 * @method \Application\Model\Bean\Category current()
 * @method \Application\Model\Bean\Category read()
 * @method \Application\Model\Bean\Category getOne()
 * @method \Application\Model\Bean\Category getByPK() getByPK($primaryKey)
 * @method \Application\Model\Collection\CategoryCollection intersect() intersect(\Application\Model\Collection\CategoryCollection $collection)
 * @method \Application\Model\Collection\CategoryCollection filter() filter(callable $function)
 * @method \Application\Model\Collection\CategoryCollection merge() merge(\Application\Model\Collection\CategoryCollection $collection)
 * @method \Application\Model\Collection\CategoryCollection diff() diff(\Application\Model\Collection\CategoryCollection $collection)
 * @method \Application\Model\Collection\CategoryCollection copy()
 */
class CategoryCollection extends Collection{

    /**
     *
     * @param Category $collectable
     */
    protected function validate($collectable)
    {
        if( !($collectable instanceof Category) ){
            throw new \InvalidArgumentException("Debe de ser un objecto Category");
        }
    }

    /**
     * @return array
     */
    public function toCombo(){
        return $this->map(function(Category $category){
            return array( $category->getIdCategory() => $category->getName() );
        });
    }

    /**
     *
     * @return \Application\Model\Collection\CategoryCollection
     */
    public function filterRoot(){
        return $this->filter(function (Category $category){
            return $category->getIdParent() == null;
        });
    }

    /**
     *
     * @param Category $category
     * @return \Application\Model\Collection\CategoryCollection
     */
    public function filterChildren(Category $category){
        return $this->filter(function (Category $child) use($category){
            return $child->getIdParent() == $category->getIdCategory();
        });
    }

    /**
     *
     * @return array
     */
    public function toNestedArray(CategoryCollection $categories){
        return $this->map(function (Category $category) use($categories){
            $isLeaf = $category->getIsLeaf();
            $isBranch = !$isLeaf;
            return array(
                $category->getIdCategory() => array(
                    'category' => $category,
                    'isLeaf' =>  $isLeaf,
                    'isBranch' => $isBranch,
                    'children' => $isBranch ? $categories->filterChildren($category)->toNestedArray($categories) : null,
                ));
        });

    }

}
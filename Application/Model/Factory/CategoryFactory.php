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

namespace Application\Model\Factory;

use Application\Model\Bean\Category;

/**
 *
 * CategoryFactory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
class CategoryFactory implements Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Category
     */
    public static function createFromArray($fields)
    {
        $category = new Category();
        self::populate($category, $fields);

        return $category;
    }

    /**
     *
     * @static
     * @param Category category
     * @param array $fields
     */
    public static function populate($category, $fields)
    {
        if( !($category instanceof Category) ){
            static::throwException("El objecto no es un Category");
        }

        if( isset($fields['id_category']) ){
            $category->setIdCategory($fields['id_category']);
        }

        if( isset($fields['id_company']) ){
            $category->setIdCompany($fields['id_company']);
        }

        if( isset($fields['id_group']) ){
            $category->setIdGroup($fields['id_group']);
        }

        if( isset($fields['id_escalation']) ){
            $category->setIdEscalation($fields['id_escalation']);
        }

        if( isset($fields['id_service_level']) ){
            $category->setIdServiceLevel($fields['id_service_level']);
        }

        if( isset($fields['id_parent']) ){
            $category->setIdParent($fields['id_parent']);
        }

        if( isset($fields['name']) ){
            $category->setName($fields['name']);
        }

        if( isset($fields['status']) ){
            $category->setStatus($fields['status']);
        }

        if( isset($fields['is_leaf']) ){
            $category->setIsLeaf($fields['is_leaf']);
        }

        if( isset($fields['note']) ){
            $category->setNote($fields['note']);
        }
    }

    /**
     * @throws CategoryException
     */
    protected static function throwException($message){
        throw new \Application\Model\Exception\CategoryException($message);
    }

}
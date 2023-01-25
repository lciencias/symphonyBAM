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

/**
 *
 * Factory
 *
 * @category Application\Model\Factory
 * @author guadalupe, chente
 */
interface Factory
{

    /**
     *
     * @static
     * @param array $fields
     * @return \Application\Model\Bean\Bean
     */
    public static function createFromArray($fields);

    /**
     *
     * @static
     * @param Bean $bean
     * @param array $fields
     */
    public static function populate($bean, $fields);

}

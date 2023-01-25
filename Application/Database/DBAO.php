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

namespace Application\Database;

/**
 *
 * DBAO
 *
 * @category Application\Database
 * @author guadalupe, chente
 */
interface DBAO
{

    /**
     *
     * @return \Zend_Db_Adapter_Abstract
     */
    public function getDbAdapter();

}
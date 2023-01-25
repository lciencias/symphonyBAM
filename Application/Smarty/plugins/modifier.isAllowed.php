<?php
/**
 * ##$BRAND_NAME$##
 *
 * ##$DESCRIPTION$##
 *
 * @category   Smarty
 * @package    Smarty_Plugins
 * @copyright  ##$COPYRIGHT$##
 * @author     ##$AUTHOR$##, $LastChangedBy$
 * @version    ##$VERSION$##, SVN:  $Id$
 */

/**
 *
 * @param mixed $var
 * @param mixed $default
 * @return string
 */
function smarty_modifier_isAllowed($resource)
{
    $acl = Zend_Registry::getInstance()->get('container')->get('manager_acl')->getAcl();
    $userSession = Zend_Registry::getInstance()->get('container')->get('user_session');
    $role = $userSession->getAccessRole()->getIdAccessRole();
    return $acl->isAllowed($role, $resource);
}

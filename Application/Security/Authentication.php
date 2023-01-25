<?php
/**
 * ##$BRAND_NAME$##
 *
 * ##$DESCRIPTION$##
 *
 * @category   Project
 * @package    Project_Security
 * @copyright  ##$COPYRIGHT$##
 * @author     ##$AUTHOR$##, $LastChangedBy$
 * @version    ##$VERSION$##, SVN:  $Id$
 */

namespace Application\Security;

use Application\Query\UserLogQuery;

use Application\Model\Factory\SessionFactory;

use Application\Model\Bean\Session;

use Application\Query\SessionQuery;

use Application\Query\UserQuery;
use Application\Model\Bean\User;
use Application\Model\Bean\UserLog;
use Application\Model\Factory\UserLogFactory;

/**
 * Esta clase funge como el actor que realiza la autenticacion del usuario
 *
 * @category   project
 * @package    Project_Security
 * @copyright  ##$COPYRIGHT$##
 */
class Authentication
{
	/**
	 * 
	 * @var int
	 */
	const MAX_LOG_IN_ATTEMPTS = 3;
    /**
     *
     * @var \Application\Model\Catalog\UserLogCatalog
     */
    private $userLogCatalog;

    /**
     *
     * @var \Application\Model\Catalog\SessionCatalog
     */
    private $sessionCatalog;
    
    /**
     *
     * @var \Application\Model\Catalog\UserCatalog
     */
    private $userCatalog;

    /**
     *
     * @param Application\Model\Catalog\UserLogCatalog $userLogCatalog
     */
    public function __construct($userLogCatalog, $sessionCatalog, $userCatalog){
        $this->userLogCatalog = $userLogCatalog;
        $this->sessionCatalog = $sessionCatalog;
        $this->userCatalog = $userCatalog;
    }

    /**
     * Metodo que autentica si existe el usuario y la contrase�a en la base de datos de lo contrario tira una excepcion.
     * ademas si existe guarda una variable en sesion la cual es util para saber si el usuario ya ha sido autenticado.
     * @param string $username Nombre de usuario
     * @param string $password Password
     * @return User $user
     * @throws Exception Si no existen coincidencias en el usuario/password
     */
    public function authenticate($username, $password)
    {
        $request = new \Zend_Controller_Request_Http();
        try
        {
            $user = UserQuery::create()
                ->whereAdd(User::USERNAME, $username)
                ->whereAdd(User::PASSWORD, sha1($password), UserQuery::EQUAL)
                ->findOne();
            if( !($user instanceof User) ){
            	$user = UserQuery::create()
            	->whereAdd(User::USERNAME, $username)
            	->findOne();
				if (($user instanceof User)){
					$userLog = UserLogFactory::createFromArray(array(
							'id_user' => $user->getIdUser(),
							'event_type' => UserLog::FAILED_LOGIN,
							'ip' => $request->getServer("REMOTE_ADDR"),
							'id_responsible' => $user->getIdUser(),
							'timestamp' => null,
							'note' => 'Fallo de inicio de sesion',
					));
					$this->userLogCatalog->create($userLog);
					$lastUpdateQuery = UserLogQuery::create();
					$lastUpdateQuery->where()->setOR();
					$lastUpdate = $lastUpdateQuery->orderBy(UserLog::ID_USER_LOG, UserLogQuery::DESC)
					->whereAdd(UserLog::EVENT_TYPE, UserLog::CREATE)
					->whereAdd(UserLog::EVENT_TYPE, UserLog::EDIT)
					->whereAdd(UserLog::EVENT_TYPE, UserLog::LOGIN)
					->findOne();
					 
					$failedLogins = UserLogQuery::create()
					->whereAdd(UserLog::EVENT_TYPE, UserLog::FAILED_LOGIN)
					->whereAdd(UserLog::ID_USER_LOG, $lastUpdate->getIdUserLog(),UserLogQuery::GREATER_THAN)
					->count();
					
					if($failedLogins >= self::MAX_LOG_IN_ATTEMPTS){
						$user->setStatus(User::$Status['Inactive']);
						$this->userCatalog->update($user);
					}
					throw new AuthException("Usuario y/o clave inv&aacute;lidos");
				}else{
					throw new AuthException("El usuario no existe");
				}
            	
                
            }

            if( $user->getStatus() == User::$Status['Inactive'] ){
                throw new AuthException("Usuario desactivado");
            }

            $session = SessionQuery::create()->whereAdd(Session::ID_USER, $user->getIdUser())->findOne();
            if( $session instanceof Session && $session->getHash() != \Zend_Session::getId() ) {
                $this->sessionCatalog->deleteByUserId($user->getIdUser());
            }

            $session = SessionFactory::createFromArray(array(
                'id_user'       =>  $user->getIdUser(),
                'hash'          =>  \Zend_Session::getId(),
                'last_request'  =>  \Zend_Date::now()->get('yyyy-MM-dd HH:mm:ss'),
            ));
            $this->sessionCatalog->create($session);

            $userLog = UserLogFactory::createFromArray(array(
                'id_user' => $user->getIdUser(),
                'event_type' => UserLog::LOGIN,
                'ip' => $request->getServer("REMOTE_ADDR"),
                'id_responsible' => $user->getIdUser(),
                'timestamp' => null,
                'note' => 'Inicio de sesi�n',
            ));
            $this->userLogCatalog->create($userLog);

            return $user;
        }
        catch(AuthException $e)
        {
            if( $username != null )
            {
//                 $user = UserQuery::create()
//                     ->whereAdd(User::USERNAME, $username)
//                     ->findOne();
//                 if( $user instanceof User )
//                 {
//                     $userLog = UserLogFactory::createFromArray(array(
//                         'id_user' => $user->getIdUser(),
//                         'event_type' => UserLog::FAILED_LOGIN,
//                         'ip' => $request->getServer("REMOTE_ADDR"),
//                         'id_responsible' => $user->getIdUser(),
//                         'timestamp' => null,
//                         'note' => 'Fall�, inicio de sesi�n',
//                     ));
//                     $this->userLogCatalog->create($userLog);
//                 }
            }
            throw $e;
        }
    }

    /**
     *
     * @param string $username
     * @param string $password
     * @param int $idAccessRole
     * @return $user
     */
    public function authenticateAs($username, $password, $idAccessRole)
    {
        $user = self::authenticate($username,$password);
        if( $user->getIdAccessRole() != $idAccessRole ){
            throw new AuthException('El usuario no tiene permisos suficientes');
        }
        return $user;
    }

}



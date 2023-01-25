<?php

/**
 * ##$BRAND_NAME$##
 *
 * ##$DESCRIPTION$##
 *
 * @category   Lib
 * @package    Lib_Security
 * @copyright  ##$COPYRIGHT$##
 * @author     ##$AUTHOR$##, $LastChangedBy$
 * @version    ##$VERSION$##, SVN:  $Id$
 */

namespace Application\Security;

use Application\Model\Bean\User;
use Application\Model\Bean\AccessRole;

/**
 * Clase para manejar la session del usuario
 *
 * @category   Lib
 * @package    Lib_Security
 * @copyright  ##$COPYRIGHT$##
 */
 class UserSession
 {

     /**
      * Variable para prevenir colisiones de sesiones
      * @var string
      */
     protected $fingerprint = null;

     /**
      * Constructor
      * @param $config
      */
     public function __construct($webconfig){
         $this->fingerprint = 'zf_' . md5($webconfig->database->params->username . '@' . $webconfig->database->params->dbname);
     }

     /**
      * Guarda un atributo en la sesion del usuario
      * @param string $name
      * @param mixed $value
      * @param string $ns Namespace
      */
    public function setAttribute($name, $value, $ns = 'common')
     {
         $session = new \Zend_Session_Namespace($this->fingerprint . '@' . $ns);
         $session->{$name} = $value;
     }

     /**
      * Obtiene un atributo de la sesion del usuario
      * @param string $name
      * @param mixed $default
      * @param string $ns Namespace
      * @return mixed
      */
     public function getAttribute($name, $default = null, $ns = 'common')
     {
         $session = new \Zend_Session_Namespace($this->fingerprint . '@' . $ns);
         return isset($session->{$name}) ? $session->{$name} : $default;
     }

     /**
      * Pregunta si existe un atributo en la sesion
      * @param string $name
      * @param string $ns Namespace
      * @return bool
      */
     public function hasAttribute($name, $ns = 'common')
     {
         $session = new \Zend_Session_Namespace($this->fingerprint . '@' . $ns);
         return isset($session->{$name});
     }

     /**
      * Elimina un atributo de la sesion del usuario
      * @param string $name
      * @param string $ns
      */
     public function removeAttribute($name, $ns = 'common')
     {
         $session = new \Zend_Session_Namespace($this->fingerprint . '@' . $ns);
         unset($session->{$name});
     }

     /**
      * Agrega una variable en sesion que se destruye al ser recuperada
      * @param string $name
      * @param mixed $value
      */
     public function setFlash($name, $value)
     {
         $this->setAttribute($name, $value, 'flash');
     }

     /**
      * Obtiene un variable flash y la destruye inmediatamente
      * @param string $name
      * @param mixed $default
      * @return mixed
      */
     public function getFlash($name, $default = null)
     {
         $flash = $this->getAttribute($name, $default, 'flash');
         $this->removeAttribute($name, 'flash');
         return $flash;
     }

     /**
      * proxy Obtiene el IdUser
      * @return int
      */
     public function getIdUser()
     {
         return $this->getBean()->getIdUser();
     }

     /**
      * proxy Obtiene el idPerson
      * @return int
      */
     public function getIdPerson()
     {
         return $this->getBean()->getIdPerson();
     }

     /**
      * proxy Obtiene el username
      * @return string
      */
     public function getUsername()
     {
         return $this->getBean()->getUsername();
     }

     /**
      * Retorna el Bean del Usuario
      * @return User
      */
     public function getBean()
     {
         require_once 'Application/Model/Bean/User.php';
         return $this->getAttribute('user', null, 'bean');
     }

     /**
      *
      * @param string $default
      * @return string
      */
     public function getLanguage($default = 'en'){
        return $this->getAttribute('language', $default, 'i18n');
     }

     /**
      *
      * @param string $language
      */
     public function setLanguage($language){
         $this->setAttribute('language', $language, 'i18n');
     }

     /**
      * Asignar el Bean para el usuario que esta en session
      * @param User $user
      */
     public function setBean(User $user)
     {
         $this->setAttribute('user', $user, 'bean');
     }

     /**
      * Asigna el Bean de AccessRole en la sesión
      * @param AccessRole $accessRole
      */
     public function setAccessRole(AccessRole $accessRole)
     {
         $this->setAttribute('accessrole',$accessRole,'accessrole');
     }

    /**
     * Retorna el Grupo de Usuario al que pertenece el Usuario
     * @return AccessRole
     */
    public function getAccessRole()
    {
        require_once 'Application/Model/Bean/AccessRole.php';
        return $this->getAttribute('accessrole', null, 'accessrole');
    }

    /**
     * Set the back url history
     * @param string $url
     */
    public function setLastUrl($url){
        $this->setAttribute('lastUrl', $url, 'utilities');
    }

    /**
     * Set the back url history
     * @param string $default
     * @return string
     */
    public function getLastUrl($default = 'index/index'){
        return $this->getAttribute('lastUrl', $default, 'utilities');
    }

    /**
     * Set the back url history
     * @param string $default
     * @return string
     */
    public function getFullLastUrl($default = 'index/index')
    {
        $params = '';
        foreach( (array) $this->getAttribute('params', array(), 'utilities') as $param => $value ){
            $params .= '/'. $param .'/'. $value;
        }
        return $this->getLastUrl($default). $params;
    }

     /**
      * Destruye la sesion del usuario
      */
     public function shutdown()
     {
         \Zend_Session::start();
         \Zend_Session::destroy();
     }

 }
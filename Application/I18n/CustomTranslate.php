<?php

namespace Application\I18n;

use Application\Model\Bean\Translate;
use Application\Query\TranslateQuery;
use Application\Security\UserSession;

/**
 *
 * @author chente
 *
 */
class CustomTranslate extends \Zend_Translate
{

    /**
     *
     * @var \Application\Security\UserSession
     */
    private $userSession;

    /**
     *
     * @var MasterTranslator
     */
    private $masterTranslator;

    /**
     * (non-PHPdoc)
     * @see Zend_Translate::__call()
     */
    public function __call($method, array $options)
    {
        list($string) = $options;

        $language = $this->userSession->getLanguage();
        if( $this->getMasterTranslator()->hasTranslate($string, $language) ){
            return $this->getMasterTranslator()->translate($string, $language);
        }else{
            return parent::__call($method, $options);
        }
    }

    /**
     * @return \Application\Security\UserSession
     */
    private function getUserSession(){
        return $this->userSession;
    }

    /**
     *
     * @param UserSession $userSession
     */
    public function setUserSession(UserSession $userSession){
        $this->userSession = $userSession;
    }

    /**
     *
     * @param MasterTranslator $masterTranslator
     */
    public function setMasterTranslator(MasterTranslator $masterTranslator){
        $this->masterTranslator = $masterTranslator;
    }

    /**
     * @return MasterTranslator
     */
    private function getMasterTranslator(){
        return $this->masterTranslator;
    }

}
<?php

namespace Application\I18n;

use Application\Storage\StorageFactory;
use Application\Storage\Chain;
use Application\Storage\File;
use Application\Model\Bean\Translate;
use Application\Query\TranslateQuery;
use Application\Security\UserSession;

/**
 *
 * @author chente
 *
 */
class MasterTranslator
{

    /**
     * @var array
     */
    private $stringsInEnglish;

    /**
     * @var array
     */
    private $stringsInSpanish;

    /**
     *
     * @var \Application\Storage\Storage
     */
    private $cache;

    /**
     *
     */
    public function __construct(){
        $this->cache = new Chain(StorageFactory::create('memory'), new File(array(
            'lifetime' => 864000,
            'automatic_serialization' => true,
        ), array('cache_dir' => 'cache/i18n')));
    }

    /**
     *
     * @param string $string
     * @param string $language
     * @return boolean
     */
    public function hasTranslate($string, $language)
    {
        $key = "{$string}-to-{$language}";
        if( $this->cache->exists($key) ){
            return true;
        }

        $strings = $this->getDBStrings($language);
        return array_key_exists($string, $strings);
    }

    /**
     *
     * @param string $string
     * @param string $language
     * @return string
     */
    public function translate($string, $language)
    {
        $key = "{$string}-to-{$language}";
        if( $this->cache->exists($key) ){
            return $this->cache->load($key);
        }

        if( $this->hasTranslate($string, $language) ){
            $strings = $this->getDBStrings($language);
            $string = $strings[$string];
            $this->cache->save($key, $string);
        }
        return $string;
    }

    /**
     *
     * @param string $language
     * @return array
     */
    private function getDBStrings($language)
    {
        static $isProcessed = null;

        if( null == $isProcessed ){
            $isProcessed = true;
            $translates = TranslateQuery::create()->setStorage($this->cache)->find();
            $this->stringsInEnglish = $translates->map(function(Translate $translate){
                return array($translate->getString() => $translate->getEn());
            });
            $this->stringsInSpanish = $translates->map(function(Translate $translate){
                return array($translate->getString() => $translate->getEs());
            });
        }
        return $language == 'es' ? $this->stringsInSpanish : $this->stringsInEnglish;
    }

    /**
     *
     * @return \Application\Storage\Storage
     */
    public function getStorage(){
        return $this->cache;
    }

}
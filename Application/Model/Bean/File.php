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

namespace Application\Model\Bean;

/**
 *
 * File
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class File extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_files';

    /**
     * Constants Fields
     */
    const ID_FILE = 'id_file';
    const URI = 'uri';
    const ORIGINAL_NAME = 'original_name';

    /**
     * @var int
     */
    private $idFile;


    /**
     * @var string
     */
    private $uri;


    /**
     * @var string
     */
    private $originalName;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdFile();
    }


    /**
     * @return int
     */
    public function getIdFile(){
        return $this->idFile;
    }

    /**
     * @param int $idFile
     * @return File
     */
    public function setIdFile($idFile){
        $this->idFile = $idFile;
        return $this;
    }


    /**
     * @return string
     */
    public function getUri(){
        return $this->uri;
    }

    /**
     * @param string $uri
     * @return File
     */
    public function setUri($uri){
        $this->uri = $uri;
        return $this;
    }


    /**
     * @return string
     */
    public function getOriginalName(){
        return $this->originalName;
    }

    /**
     * @param string $originalName
     * @return File
     */
    public function setOriginalName($originalName){
        $this->originalName = $originalName;
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_file' => $this->getIdFile(),
            'uri' => $this->getUri(),
            'original_name' => $this->getOriginalName(),
        );
        return $array;
    }

}
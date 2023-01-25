<?php
/**
 * CubeSoftware
 *
 * 
 *
 * @copyright 
 * @author    Luis Hernandez, $LastChangedBy$
 * @version   
 */

namespace Application\Model\Bean;

/**
 *
 * UserGroup
 *
 * @category Application\Model\Bean
 * @author Luis Hernandez
 */
class UserGroup extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_user_group';

    /**
     * Constants Fields
     */
    const ID_USER = 'id_user';
    const ID_GROUP = 'id_group';

    /**
     * @var int
     */
    private $idUser;


    /**
     * @var int
     */
    private $idGroup;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdUser();
    }


    /**
     * @return int
     */
    public function getIdUser(){
        return $this->idUser;
    }

    /**
     * @param int $idUser
     * @return UserGroup
     */
    public function setIdUser($idUser){
		$this->idUser = $idUser;	
        return $this;
    }


    /**
     * @return int
     */
    public function getIdGroup(){
        return $this->idGroup;
    }

    /**
     * @param int $idGroup
     * @return UserGroup
     */
    public function setIdGroup($idGroup){
		$this->idGroup = $idGroup;	
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_user' => $this->getIdUser(),
            'id_group' => $this->getIdGroup(),
        );
        return $array;
    }

}

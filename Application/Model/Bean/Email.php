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
 * Email
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class Email extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_common_emails';

    /**
     * Constants Fields
     */
    const ID_EMAIL = 'id_email';
    const EMAIL = 'email';

    /**
     * @var int
     */
    private $idEmail;


    /**
     * @var string
     */
    private $email;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdEmail();
    }


    /**
     * @return int
     */
    public function getIdEmail(){
        return $this->idEmail;
    }

    /**
     * @param int $idEmail
     * @return Email
     */
    public function setIdEmail($idEmail){
        $this->idEmail = $idEmail;
        return $this;
    }


    /**
     * @return string
     */
    public function getEmail(){
        return $this->email;
    }

    /**
     * @param string $email
     * @return Email
     */
    public function setEmail($email){
        $this->email = $email;
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_email' => $this->getIdEmail(),
            'email' => $this->getEmail(),
        );
        return $array;
    }

}
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
 * SecurityController
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class SecurityController extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_common_security_controllers';

    /**
     * Constants Fields
     */
    const ID_CONTROLLER = 'id_controller';
    const NAME = 'name';

    /**
     * @var int
     */
    private $idController;


    /**
     * @var string
     */
    private $name;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdController();
    }


    /**
     * @return int
     */
    public function getIdController(){
        return $this->idController;
    }

    /**
     * @param int $idController
     * @return SecurityController
     */
    public function setIdController($idController){
        $this->idController = $idController;
        return $this;
    }


    /**
     * @return string
     */
    public function getName(){
        return $this->name;
    }

    /**
     * @param string $name
     * @return SecurityController
     */
    public function setName($name){
        $this->name = $name;
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_controller' => $this->getIdController(),
            'name' => $this->getName(),
        );
        return $array;
    }

}
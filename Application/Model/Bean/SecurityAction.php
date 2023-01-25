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
 * SecurityAction
 *
 * @category Application\Model\Bean
 * @author guadalupe, chente
 */
class SecurityAction extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_common_security_actions';

    /**
     * Constants Fields
     */
    const ID_ACTION = 'id_action';
    const ID_CONTROLLER = 'id_controller';
    const NAME = 'name';
    const TAG_MODULE = 'tag_module';
    const TAG_ACTION = 'tag_action';

    /**
     * @var int
     */
    private $idAction;


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
     * @var string
     */
    private $tagModule;

    /**
     *
     * @var string
     */
    private $tagAction;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdAction();
    }


    /**
     * @return int
     */
    public function getIdAction(){
        return $this->idAction;
    }

    /**
     * @param int $idAction
     * @return SecurityAction
     */
    public function setIdAction($idAction){
        $this->idAction = $idAction;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdController(){
        return $this->idController;
    }

    /**
     * @param int $idController
     * @return SecurityAction
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
     * @return SecurityAction
     */
    public function setName($name){
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getTagModule(){
        return $this->tagModule;
    }

    /**
     * @param string $name
     * @return SecurityAction
     */
    public function setTagModule($tagModule){
        $this->tagModule = $tagModule;
        return $this;
    }

    /**
     * @return string
     */
    public function getTagAction(){
        return $this->tagAction;
    }

    /**
     * @param string $name
     * @return SecurityAction
     */
    public function setTagAction($tagAction){
        $this->tagAction = $tagAction;
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_action' => $this->getIdAction(),
            'id_controller' => $this->getIdController(),
            'name' => $this->getName(),
            'tag_module' => $this->getTagModule(),
            'tag_action' => $this->getTagAction(),
        );
        return $array;
    }

}
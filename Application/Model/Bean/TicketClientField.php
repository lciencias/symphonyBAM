<?php
/**
 * PCS Mexico
 *
 * Symphony BAM
 *
 * @copyright Copyright (c) PCS Mexico (http://www.pcsmexico.com)
 * @author    jose luis, $LastChangedBy$
 * @version   2
 */

namespace Application\Model\Bean;

/**
 *
 * TicketClientField
 *
 * @category Application\Model\Bean
 * @author jose luis
 */
class TicketClientField extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_ticket_client_fields';

    /**
     * Constants Fields
     */
    const ID_TICKET_CLIENT_FIELD = 'id_ticket_client_field';
    const ID_TICKET_CLIENT = 'id_ticket_client';
    const ID_FIELD = 'id_field';
    const VALUE = 'value';

    /**
     * @var int
     */
    private $idTicketClientField;


    /**
     * @var int
     */
    private $idTicketClient;


    /**
     * @var int
     */
    private $idField;


    /**
     * @var string
     */
    private $value;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdTicketClientField();
    }


    /**
     * @return int
     */
    public function getIdTicketClientField(){
        return $this->idTicketClientField;
    }

    /**
     * @param int $idTicketClientField
     * @return TicketClientField
     */
    public function setIdTicketClientField($idTicketClientField){
        $this->idTicketClientField = $idTicketClientField;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdTicketClient(){
        return $this->idTicketClient;
    }

    /**
     * @param int $idTicketClient
     * @return TicketClientField
     */
    public function setIdTicketClient($idTicketClient){
        $this->idTicketClient = $idTicketClient;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdField(){
        return $this->idField;
    }

    /**
     * @param int $idField
     * @return TicketClientField
     */
    public function setIdField($idField){
        $this->idField = $idField;
        return $this;
    }


    /**
     * @return string
     */
    public function getValue(){
        return $this->value;
    }

    /**
     * @param string $value
     * @return TicketClientField
     */
    public function setValue($value){
        $this->value = $value;
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_ticket_client_field' => $this->getIdTicketClientField(),
            'id_ticket_client' => $this->getIdTicketClient(),
            'id_field' => $this->getIdField(),
            'value' => $this->getValue(),
        );
        return $array;
    }

}
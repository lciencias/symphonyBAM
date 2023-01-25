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
 * TicketClientDocument
 *
 * @category Application\Model\Bean
 * @author jose luis
 */
class TicketClientDocument extends AbstractBean{

    /**
     * TABLENAME
     */
    const TABLENAME = 'pcs_symphony_ticket_client_documents';

    /**
     * Constants Fields
     */
    const ID_TICKET_CLIENT_DOCUMENT = 'id_ticket_client_document';
    const ID_DOCUMENT = 'id_document';
    const ID_TICKET_CLIENT = 'id_ticket_client';
    const ID_FILE = 'id_file';

    /**
     * @var int
     */
    private $idTicketClientDocument;


    /**
     * @var int
     */
    private $idDocument;


    /**
     * @var int
     */
    private $idTicketClient;


    /**
     * @var int
     */
    private $idFile;


    /**
     *
     * @return int
     */
    public function getIndex(){
        return $this->getIdTicketClientDocument();
    }


    /**
     * @return int
     */
    public function getIdTicketClientDocument(){
        return $this->idTicketClientDocument;
    }

    /**
     * @param int $idTicketClientDocument
     * @return TicketClientDocument
     */
    public function setIdTicketClientDocument($idTicketClientDocument){
        $this->idTicketClientDocument = $idTicketClientDocument;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdDocument(){
        return $this->idDocument;
    }

    /**
     * @param int $idDocument
     * @return TicketClientDocument
     */
    public function setIdDocument($idDocument){
        $this->idDocument = $idDocument;
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
     * @return TicketClientDocument
     */
    public function setIdTicketClient($idTicketClient){
        $this->idTicketClient = $idTicketClient;
        return $this;
    }


    /**
     * @return int
     */
    public function getIdFile(){
        return $this->idFile;
    }

    /**
     * @param int $idFile
     * @return TicketClientDocument
     */
    public function setIdFile($idFile){
        $this->idFile = $idFile;
        return $this;
    }


    /**
     * Convert to array
     * @return array
     */
    public function toArray()
    {
        $array = array(
            'id_ticket_client_document' => $this->getIdTicketClientDocument(),
            'id_document' => $this->getIdDocument(),
            'id_ticket_client' => $this->getIdTicketClient(),
            'id_file' => $this->getIdFile(),
        );
        return $array;
    }

}
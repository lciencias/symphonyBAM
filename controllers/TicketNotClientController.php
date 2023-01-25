<?php
/**
 * ##$BRAND_NAME$##
 *
 * ##$DESCRIPTION$##
 *
 * @category   Project
 * @package    Project_Controllers
 * @copyright  ##$COPYRIGHT$##
 * @author     ##$AUTHOR$##, $LastChangedBy$
 * @version    ##$VERSION$##, SVN:  $Id$
 */

use Application\Controller\BaseController;
use PHPeriod\Duration;
use Application\Manager\FixManager;
use Application\Model\Catalog\ReasonsCatalog;
use Application\Query\TicketTypeQuery;
use Application\Model\Bean\TicketType;
use Application\Query\ReasonsQuery;
use Application\Model\Bean\Reasons;
use Application\Webservice\WSClient;
use Application\Query\BranchQuery;
use Application\Model\Bean\Branch;
use Application\Query\ProductsQuery;
use Application\Model\Bean\Products;
use Application\Query\ClientCategoryQuery;
use Application\Model\Bean\ClientCategory;


/**
 *
 * 
 */
class TicketNotClientController extends BaseController{
    
     /**
     * @module Not Client
     * @action Activity
     */
    public function indexAction()
    {
        $ticketTipe=  TicketTypeQuery::create()->whereAdd(TicketType::ID_TICKET_TYPE, TicketType::$TicketType['Consulta'])->find()->toCombo();
        $this->view->ticketType=$ticketTipe;
        $this->view->reasons = array('' => $this->i18n->_('Select')) +  ClientCategoryQuery::create()->whereAdd(ClientCategory::ID_TICKET_TYPE, TicketType::$TicketType['Consulta'])
        		->whereAdd(ClientCategory::TYPE, array(1,2,3))
        		->find()->toCombo();
        $this->view->comboPersonal=$this->translateCombo(array(1=>"Nombre",2=>"Puesto",3=>utf8_encode("&Aacute;rea"),4=>utf8_encode("Direcci&oacute;n")));
        $this->view->branches= array('' => $this->i18n->_('All')) + BranchQuery::create()->whereAdd(Branch::STATUS,  Branch::$Status['Active'])->find()->toCombo();
        $this->view->products= ProductsQuery::create()->whereAdd(Products::STATUS,  Products::$Status['Active'])->find()->toCombo();
        
    }
    
    public function getSubtypeByIdAction(){
        $params = $this->getRequest()->getParams();
        $id=$params['id'];
        $reason= ClientCategoryQuery::create()->findByPK($id);
        die($reason->getType());    
    }
    
    public function searchWsAction(){
        $params = $this->getRequest()->getParams();        
        $WSClient = new WSClient();
        if($WSClient->getError()){
            die(json_encode(array("error"=>$WSClient->getError())));
        }
        $fixManager= new FixManager();
        $subType=$params['subtype'];
        if($subType==1){        	
            $result=$WSClient->getIntranetInfo();
            $result['url'] = trim($result['url']);
            die(json_encode($result));        
        }
        if($subType==2){ // sucursales
            $idBranch=$params['id_branch'];
            if($idBranch !='')
            $branches=  BranchQuery::create()->addColumns(array("name","address","scheduled"))->whereAdd(Branch::STATUS, Branch::$Status['Active'])->whereAdd (Branch::ID_BRANCH, $idBranch)->fetchAll();
            else
            $branches=  BranchQuery::create()->addColumns(array("name","address","scheduled"))->whereAdd(Branch::STATUS, Branch::$Status['Active'])->fetchAll();
            $newBranch=array();
            foreach($branches as $data){
                $newBranch[]=array("name"=> utf8_encode($data['name']),"scheduled"=>utf8_encode($data['scheduled']),"address"=>utf8_encode($data['address']));
            }
             die(json_encode($newBranch)); 
        }
        if($subType==3){
            $idProduct=$params['id_product'];
            $products=  ProductsQuery::create()->whereAdd(Products::ID_PRODUCT,$idProduct)->fetchAll();
            $result=$products[0];
            $result=$fixManager->utf8_encode_array($result);
            die(json_encode($result));        
        }
        
    }
        
    public function saveTicketAction(){
        $params = $this->getRequest()->getParams();
        $idProduct = ProductsQuery::create()->whereAdd(Products::ESPECIAL, 2)->fetchOne();
        $params['controller']      ="ticket-client";
        $user=$this->getUser()->getBean();
        $params['id_channel']      	  = 1;
        $params['id_origin_branch']	  = $user->getIdBranch();
        $params['id_reported_branch'] = $user->getIdBranch();
        $params['id_client_category'] = $params['id_reason']; // NUMERO FIJO para consultas
        $params['id_assigment']       = $user->getIdUser();
        $params['id_assigment']       = $user->getIdUser();        
        $params['account_number']     = '0000000000';
        $params['folio_condition']    = 1;
        $params['id_entidad']         = 9;
        $params['id_product']         = $idProduct;
        $ticket = $this->getTicketService()->create($params, $this->getUser()->getBean());
		$resolution = \Application\Query\ClientResolutionQuery::create()->findByPK(1); // numero fijo para las consultas
        $this->getTicketService()->assign($ticket,$this->getUser()->getBean(), $this->getUser()->getBean());
        $this->getTicketService()->resolveTicketClient($ticket,$resolution, $this->getUser()->getBean(), $note, null, null);
        die(json_encode(array('ok')));
    }


    
    /**
     * @return \Application\Model\Catalog\ChannelCatalog
     */
    protected function getReasonsCatalog(){
        return $this->getContainer()->get('ReasonsCatalog');
    }
    
     /**
     * @return Application\Service\TicketService
     */
    private function getTicketService(){
    	return $this->getContainer()->get('TicketService');
    }
    

}

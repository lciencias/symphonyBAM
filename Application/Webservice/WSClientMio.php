<?php
namespace Application\Webservice;
/**
 * PCS Mexico
 *
 * SAP WebService
 *
 * @category   WebService
 * @package
 * @copyright  PCS Mexico
 * @author     Chente, $LastChangedBy$
 * @version    1.0.2 SVN: $Id$
 */

/**
 * dependeces
 */

/**
 * Clase
 *
 * @category   WebService
 * @copyright  PCS Mexico
 * @author     joseluis
 * @version    1.0.2 SVN: $Revision$
 */

use Application\Model\Factory\ClientAccountFactory;
use Application\Model\Bean\ClientAccount;
use Application\Model\Collection\ClientAccountCollection;
use Application\Model\Factory\ClientDataFactory;
use Application\Model\Bean\ClientData;
use Application\Model\Collection\ClientDataCollection;
use Application\Model\Collection\ProductsCollection;
use Application\Model\Bean\Products;
use Application\Model\Factory\ProductsFactory;
use Automatic\Transition;
use Application\Model\Bean\Transactions;
use Application\Model\Collection\TransactionsCollection;
use Application\Model\Factory\TransactionsFactory;
use Application\Model\Bean\Prod;
use Application\Model\Factory\ProdFactory;
use Application\Model\Collection\ProdCollection;
use Application\Query\BranchQuery;
use Application\Model\Bean\Branch;

class WSClient
{

	/**
	 *
	 * @var string
	 */
	protected $wsdl;

	/**
	 *
	 * @var array
	 */
	protected  $options = array(
			'soap_version'=>SOAP_1_1,
			'exceptions'=>1,
			'trace'=>1,
			'cache_wsdl'=>false,
			'encoding'=>'UTF-8',
	);

	/**
	 *
	 * @var \SoapClient
	 */
	protected $soapClient;
	
	/**
	 * @var string
	 */
	protected $user;
	
	/**
	 * @var string
	 */
	protected $password;
	
	/**
	 * 
	 * @var \Zend_Config
	 */
	protected $webConfig;

	/**
	 * @var modo
	 */
	protected $developmentMode;
        
        
        /**
	 * @var modo
	 */
	protected $token;
        
        
        /**
	 * @var modo
	 */
	private $error;
        
        
        
        
        
	/**
	 * construct
	 */
        	public function __construct()
	{
		try {
                    $this->error=FALSE;
                    if (!$this->getDevelopmentMode() || $this->getDevelopmentMode()==NULL) {
			$webConfig = $this->getRegistry()->config->webService;
			$this->setWebConfig($webConfig);
			$this->setUser($this->getWebConfig()->user);
			$this->setPassword($this->getWebConfig()->password);
			$this->setWsdl($this->getWebConfig()->wsdl);
//                        $this->token='';
                        $token_session = new \Zend_Session_Namespace('token_session');
                        if(!$token_session->token or empty($token_session->token)){
                            if (!$this->getDevelopmentMode())
                            $response=$this->createToken();
                            if(!$response || $response['error']){
                                $this->error=$this->getWebConfig()->wserror;
//                                throw new Exception($this->i18n->_("Error de conexión con el webservice"));
                            }
                        }
                    }
		}catch (Exception $e){
			throw $e;
		}
		
	}
        
//        public function createToken(){
//            $uri="login/spf/".$this->getWebConfig()->user."/".$this->getWebConfig()->password;
//            $url=$this->getWebConfig()->wsdl.$uri;
//            $time=$this->getWebConfig()->timeout;
//            $opts = array('http'=>array('header' => 'Connection: close','timeout' => $time));
//            $context = stream_context_create($opts);
//            $content=@file_get_contents($url, false, $context);
//            $response = json_decode($content,true);
//            $token_session = new \Zend_Session_Namespace('token_session');
//            $token_session->token = $response['token'];
//        }
//
//        public function peticion($params){
//            $service="data/";
//            $token_session = new \Zend_Session_Namespace('token_session');
//            $token=$token_session->token."/";
//            $url=$this->getWebConfig()->wsdl.$service.$token.$params;
//            $time=$this->getWebConfig()->timeout;
//            $opts = array('http'=>array('header' => 'Connection: close','timeout' => $time));
//            $context = stream_context_create($opts);
//            @$content=@file_get_contents($url, false, $context);
//            $response = json_decode($content,true);
//            if(is_array($response['error'])){
//            if($response['error']['codigo']==2){
//                $this->token='';
//                $this->createToken();
//                $this->peticion($params);
//            }    
//            }
//            
//            return $response;
//        }
        
        public function createToken(){
            $uri="login/spf/".$this->getWebConfig()->user."/".$this->getWebConfig()->password;
            $url=$this->getWebConfig()->wsdl.$uri;
            $time=$this->getWebConfig()->timeout;
            $content = $this->file_get_contents_curl($url,$time);
            if($content){
                $response = json_decode($content,true);
                if(is_array($response['error'])){
                        if($response['error']['codigo']==2){
                            $this->token='';
                            $this->createToken();
                            $this->peticion($params);
                        }else
                            $response=array("error"=>$response['error']);
                    }else{
                            $token_session = new \Zend_Session_Namespace('token_session');
                            $token_session->token = $response['token'];                        
                    }
            }else
                $response=array("error"=>$this->getWebConfig()->wserror);
            return $response;
        }

        public function file_get_contents_curl($url, $timeout = 10) {
            $ch = curl_init();
            curl_setopt ($ch, CURLOPT_URL, $url);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $file_contents = curl_exec($ch);
              curl_close($ch);
            return ($file_contents) ? $file_contents : FALSE;
          }

        public function peticion($params){
            $service="data/";
            $token_session = new \Zend_Session_Namespace('token_session');
            $token=$token_session->token."/";
            $url=$this->getWebConfig()->wsdl.$service.$token.$params;
            $time=$this->getWebConfig()->timeout;
            $opts = array('http'=>array('header' => 'Connection: close','timeout' => $time));
            $context = stream_context_create($opts);
            $content = $this->file_get_contents_curl($url,10); 
//            @$content=@file_get_contents($url, false, $context);
            if($content){
                $response = json_decode($content,true);
                if(is_array($response['error'])){
                        if($response['error']['codigo']==2){
                            $this->token='';
                            $this->createToken();
                            $this->peticion($params);
                        }else
                            $response=array("error"=>$response['error']);
                    }
            }else
                $response=array("error"=>$this->getWebConfig()->wserror);
            
            return $response;
        }
         

	/**
	 * @return \Zend_Registry
	 */
	public function getRegistry(){
		return \Zend_Registry::getInstance();
	}
	/**
	 * 
	 * @param \Zend_Config $webConfig
	 */
	public function setWebConfig(\Zend_Config $webConfig){
		$this->webConfig = $webConfig;
	}
	/**
	 * @return \Zend_Config
	 */
	public function getWebConfig(){
		return $this->webConfig;
	}
	/**
	 * @return the $wsdl
	 */
	public function getWsdl()
	{
		return $this->wsdl;
	}

	/**
	 * @return the $options
	 */
	public function getOptions()
	{
		return $this->options;
	}

	/**
	 * @param string $wsdl
	 */
	public function setWsdl($wsdl)
	{
		$this->wsdl = $wsdl;
	}

	/**
	 * @param array $options
	 */
	public function setOptions($options)
	{
		$this->options = $options;
	}

	/**
	 * @return Zend_Soap_Client
	 */
	public function getSoapClient()
	{
		return $this->soapClient;
	}

	/**
	 * @param Zend_Soap_Client $soapClient
	 */
	public function setSoapClient($soapClient)
	{
		$this->soapClient = $soapClient;
	}
	
	/**
	 * 
	 * @param string $password
	 */
	public function setPassword($password){
		$this->password = $password;
	}
	
	/**
	 * @return string
	 */
	public function getPassword(){
		return $this->password;
	}
	
	/**
	 * 
	 * @param string $user
	 */
	public function setUser($user){
		$this->user = $user;
	}
	
	/**
	 * @return string
	 */
	public function getUser(){
		return $this->user;
	}
        
        /**
	 * 
	 * @param string $token
	 */
	public function setToken($token){
		$this->token = $token;
	}
	
	/**
	 * @return string
	 */
	public function getToken(){
		return $this->token;
	}
        
        
        /**
	 * @param string $error
	 */
	public function setError($error)
	{
		$this->error = $error;
	}

	/**
	 * @return string
	 */
	public function getError(){
		return $this->error;
	}
        
	
	/**
	 * 
	 * @param unknown_type $parameters
	 */
	public function createLogrequest($parameters)
	{
		$log = fopen("public/logs/webServicesLog/request.txt", "a+");
		$date = new \Zend_Date();
		$parameters["time"] = $date->toString("dd-MM-yyyy hh:mm:ss");
		fwrite($log, \Zend_Json::encode($parameters) . PHP_EOL );
		fclose ( $log );
	}
	/**
	 *
	 * @return ClientDataCollection
	 * @param string $account        	
	 */
	public function getInformationByAccount($account) {
		$results = $this->soapClient->get_data_customer ( $account, $this->getUser (), $this->getPassword () );
		$clientDataCollection = new ClientDataCollection ();
		if (! isset ( $results [0]->error ) && is_array ( $results )) {
			foreach ( $results as $result ) {
				$clientData = new ClientData ();
				ClientDataFactory::populateFromStdClass ( $clientData, $result );
				$clientDataCollection->append ( $clientData );
			}
		}
		return $clientDataCollection;
	}
	/**
	 *
	 * @return ClientDataCollection
	 * @param string $account        	
	 * @param string $clientNumber        	
	 * @param string $rfc        	
	 * @param string $name        	
	 */
	public function getInformationByMixedSearch($account, $clientNumber, $rfc, $name, $lastName,$middleName, $folio) {
            $clientDataCollection = new ClientDataCollection ();
		if (!$this->getDevelopmentMode()){
                    $branches = BranchQuery::create ()->addColumns ( array (
					Branch::ID_BAM,
					Branch::ID_BRANCH 
			) )->fetchPairs ();
			$uri = "DatosCliente/noCuenta=$account|noCliente=$clientNumber|rfcCliente=$rfc|nombreCliente=$name|apellidoPaterno=$lastName|apellidoMaterno=$middleName";
			// $uri="DatosCliente/noCuenta=|noCliente=|rfcCliente=$rfc|nombreCliente=aaa|apellidoPaterno=|apellidoMaterno=";
			$datos = $this->peticion ($uri);
			if($datos['error'])
                	return $datos;
			else{
				foreach ($datos['datosCliente'] as $data ) {
					$data['sucursalOrigen'] = $branches [$data['sucursalOrigen']];
					$clientData = new ClientData ();
					$clientData->setBirthday($data['fechaNacimiento']);
					$clientData->setClientNumber($data['noCliente']);
					$clientData->setColony($data['colonia']);
					$clientData->setExternalNumber($data['noExterior']);
					$clientData->setHomePhone($data['telefono']);
					$clientData->setInternalNumber($data['noInterior']);
					$clientData->setMobilePhone($data['movil']);
					$clientData->setName ($data['nombreCliente']. " " . $data['apellidoPaterno'] . " " . $data['apellidoMaterno'] );
					$clientData->setRfc ($data['rfc'] );
                    $clientData->setState($data['estado']);
                    $clientData->setStreet($data['calle']);
                    $clientData->setTown($data['cdDelegacion']);
                    $clientData->setZipCode($data['cp']);
                    $clientData->setIdBranch($data['sucursalOrigen']);
                    $clientData->setEmail($data['email']);
                    $clientData->setCardType($data['tipoTarjeta']);
                    $clientData->setEmployee($data['empleadoNomina']);
                    $clientData->setIdEntidad($data['identidad']);
                    $clientDataCollection->append($clientData);
                }
			}
		
		}else{
		$clientDataCollection->append ($this->getExampleClientData());
			
		}
		return $clientDataCollection;
	}
        
        public function getProductsBase(){
            
            
		if(!$this->getDevelopmentMode() || $this->getDevelopmentMode()==''){
                        $uri="ProductosBase/";
                        $datos=$this->peticion($uri);
                        if($datos['error'])
                            return $datos;
                        else
                        return $datos['productosBase'];
		}else{
			$productos=array(3=>"Cheque",4=>"Banca en linea");
                        $file='{"productosBase":{"productos":{"1":{"idBam": "1","nombreProducto":"Cheque","estatus":"1"},"2":{"idBam": "2", "nombreProducto": "Banca en linea", "estatus": "1"}}}}';
                        $productos=json_decode($file,true);
		}
		return $productos['productosBase']['productos'];
	}
        
        public function getViewLog($idTx,$fechaTx){                    
		if(!$this->getDevelopmentMode() || $this->getDevelopmentMode()==''){
                        $uri="VerLog/".$idTx;
                        $datos=$this->peticion($uri);
                        if($datos['error'])
                            return $datos;
                        else
//                        print_r($log['verLog']['conceptos']['concepto']);
                        return $datos['verLog']['conceptos']['concepto'];
                }
                else{
				$file='{"verLog":{"conceptos":{"1":{"nombre":"TRANSACCIÓN","detalles":{"1":{"nombre":"RedLógicaEmisor","valor":"PROS"},"2":{"nombre":"FIID","valor":"B128"}}},"2":{"nombre":"TOKENQ2/IDMEDIODEACCESO","detalles":{"1":{"nombre":"Mediodeacceso","valor":"04"},"2":{"nombre":"ComercioInterred","valor":""}}}}}}';
                $log=json_decode(utf8_encode($file),true);
				return $log['verLog']['conceptos'];
			}
			return $log['verLog']['conceptos'];
		}
        
        public function getSaldo($account){                    
		if(!$this->getDevelopmentMode() || $this->getDevelopmentMode()==''){
                        $uri="SaldoDisponible/".$account;
                        $datos=$this->peticion($uri);
                        if($datos['error'])
                            return $datos;
                        return $datos['saldoDisponible'];
                }
                else{
			return array("65.49");	
                    }
		}        
                
                
        public function getAmortizaciones($accounNumber){                    
		if(!$this->getDevelopmentMode() || $this->getDevelopmentMode()==''){
                        $uri="VerAmortizaciones/".$accounNumber;
                        $datos=$this->peticion($uri);
                        if($datos['error'])
                            return $datos;
                        else
                        return $datos['verAmortizaciones'];
                }
                else{
				
		}        
        }
        
        public function getIntranetInfo(){  
		if(!$this->getDevelopmentMode() || $this->getDevelopmentMode()==''){
                        $uri="DatosEmpleadosIntranet/";
                        $datos=$this->peticion($uri);
                        if($datos['error'])
                            return $datos;
                        else{
                            $content = $this->file_get_contents_curl($datos['url'],10);
                            $datos['exist']= 0;
                            if(trim($datos['url']) != ''){
                            	$datos['exist']= 1;
                            }
                            return $datos;
                        }
                        
                }
                else{
				
		}        
        }
         public function getViewAmortizaciones($noContrato,$fechaIni,$fechaFin){            
		if(!$this->getDevelopmentMode() || $this->getDevelopmentMode()==''){
                        $uri="VerAmortizaciones/";
                        $log=$this->peticion($uri);
                        return $log['VerAmortizaciones']['amortizaciones'];
		}else{
                        $file='{"VerAmortizaciones":{"amortizaciones":{"1": {"fechaAnono": "14/05/2016", "mensualidad": "Mayo", "monto": "$256.50"},"2":{"fechaAnono": "16/06/2016", "mensualidad": "Junio", "monto": "$256.50"}}}}';
                        $log=json_decode($file,true);
                        return $log['VerAmortizaciones']['amortizaciones'];
		}
		return $log['VerAmortizaciones']['amortizaciones'];
	}
        
        public function getBuenafe($folio){            
		if(!$this->getDevelopmentMode() || $this->getDevelopmentMode()==''){
                        $uri="DatosAbonoBuenaFe/".$folio;
                        $log=$this->peticion($uri);
                        return $log;
		}else{
                        
		}
		
	}
        
                
        public function getNotClientInfo($subType){
            	if(!$this->getDevelopmentMode()){

		}else{
                        switch($subType){
                            case '1':
                                $file='{"datosEmpleadosIntranet":{"datosEmpleados":{"1":{"nombre": "Alfonso Solis Mena", "extension": "5635", "puesto": "Directot", "area": "Prevención de fraudes", "direccion": "Operaciones"},"2":{"nombre": "Roldan Camil Estrada", "extension": "5565", "puesto": "Subdirectos", "area": "Sistemas de pago", "direccion": "Operaciones"}}}}';
                                $file=utf8_encode($file);
                                $productos=json_decode($file,true);
                                return $productos['datosEmpleadosIntranet']['datosEmpleados'];
                                break;
                            case '2':
                                $file='{"datosSucursalIntranet":{"datosSucursales":{"1": {"idBam": "2","nombreSucursal": "Norte", "estado": "1","domicilio": "Insurgentes norte No. 24 Col. Insurgentes norte ", "horarios": "De Lunes a Viernes de 09:00 a 18:00 y Sabados de 09:00 a 14:00", "estatus": "1"},"2":{"idBam": "3","nombreSucursal": "Sur", "estado": "2", "domicilio": "Insurgentes sur No. 4 Col. Insurgentes sur ", "horarios": "De Lunes a Viernes de 09:00 a 18:00 y Sabados de 09:00 a 14:00", "estatus": "2"}}}}';
                                $productos=json_decode($file,true);
                                return $productos['datosSucursalIntranet']['datosSucursales'];
                                break;
                        }
		}
                }
        
        
        public function getTransactionByType($type,$idTransaction=null){
		if(!$this->getDevelopmentMode()){
//                    $uri="DetalleTransaccionTipo/".$type."|$idTransaction";
                    $uri="DetalleTransaccionTipo/$type|$idTransaction";
                    if($type ==1){
                        $datos=$this->peticion($uri);
//                         print_r($datos);
//                         die();
                        if($datos['error'])
                            return $datos;
                        else{
                             return $datos['detalleTransaccionTipo'][0];
                        }
                    }
                    if($type ==2){
                        $datos=$this->peticion($uri);
                        if($datos['error'])
                            return $datos;
                        else{
                            return $datos['detalleTransaccionTipo'][0];
                        }
                    }
                    if($type ==3){
                        $datos=$this->peticion($uri);
                        if($datos['error']) return $datos;
                        else return $datos['detalleTransaccionTipo'][0];
                    }
                   if($type ==4){
                        $datos=$this->peticion($uri);
                        if($datos['error']) return $datos;
                        else return $datos['detalleTransaccionTipo'][0];
                    }
                    if($type ==5){
                        $datos=$this->peticion($uri);
                        if($datos['error']) return $datos;
                        else return $datos['detalleTransaccionTipo'][0];
                    }
                    if($type ==6){
                        $datos=$this->peticion($uri);
                        if($datos['error']) return $datos;
                        else return $datos['detalleTransaccionTipo'][0];
                    }
                    if($type ==7){
                        $datos=$this->peticion($uri);
                        if($datos['error']) return $datos;
                        else return $datos['detalleTransaccionTipo'][0];
                    }
                     if($type ==8){
                        $datos=$this->peticion($uri);
                        if($datos['error']) return $datos;
                        else return $datos['detalleTransaccionTipo'];
                    }
                    
                    
                    
                    
                    
                    
		}else{
                    if($type==1){
                        $detalle='{"DetalleTransaccionTipo":{"transaction":{"1256":{ "idT24": "1256","fechaTx": "14/05/2016","importe": "$256.50","tipoTx": "Compra",'
                                . '"nemotecnico": "","sucursal": "","pem": "","horaTx": "15:25","respuesta": "","motivoRechazo": "","noAuth": "","secuencia": "",'
                                . '"respArqueo": "","estatus":"Aprobada","motivoRechazo": "","reverso": "Parcial","montoReverso": "$1,102.50","sobrante": "$206.50",'
                                . '"caseteraRechazo": "$34.00","montoEntregado": "$100.00","billetes50": "2","billetes100": "0","billetes200": "0","billetes500": "0"}}}}';
                        $response=json_decode($detalle,true);
                        return $response['DetalleTransaccionTipo']['transaction'];
                    }
                    if($type==2){
                        $detalle='{"DetalleTransaccionTipo":{"transaction":{"1256":{"idT24": "1256", "ctaClabe":"142536789563565155","banco": "Banamex","beneficiario": "Juan alberto Perez Roa",
                            "rfcBeneficiario": "MUP6350525156","concepto": "$","importeTx": "$34.00","importeTx": "$34.00","origenOperacion": "Norte",
                            "operado": "Norte","canal": "Norte","sucursal": "Norte","fechaProg": "14/05/2016","horaProg": "15:25","fechaTx": "15/05/2016","horaTx": "16:25","status": ""}}}}';
                        $response=json_decode($detalle,true);
                        return $response['DetalleTransaccionTipo']['transaction'];
                    }
                    if($type==3){
                        $detalle='{"DetalleTransaccionTipo":{"transaction":{"1256":{"idT24": "1256","clienteDeposito": "Juan alberto Perez Roa","ctaDeposito": "14256985","concepto": "El que sea",
                            "importeTx": "$34.00","origenOperacion": "Norte","operado": "Norte","canal": "Norte","sucursal": "Norte","fechaRegistro": "14/05/2016","horaRegistro": "15:25","fechaProg": "15/05/2016","status": ""}}}}';
                        $response=json_decode($detalle,true);
                        return $response['DetalleTransaccionTipo']['transaction'];
                    }
                    if($type==4){
                        $detalle='{"DetalleTransaccionTipo":{"transaction":{"1256":{"idT24": "1256","noTarjeta": "51651857","banco": "Banorte","importe": "$256.50","origenOperacion": "Norte",                          "operado": "Norte","canal": "Norte","sucursal": "Norte","fechaRegistro": "14/05/2016","horaRegistro": "15:25","fechaProg": "15/05/2016","status":""}}}}';
                        $response=json_decode($detalle,true);
                        return $response['DetalleTransaccionTipo']['transaction'];
                    }
                    if($type==5){
                        $detalle='{"DetalleTransaccionTipo":{"transaction":{"1256":{"idT24": "1256","referencia": "51651857","motivo": "Pago agua","importe": "$256.50","origenOperacion": "Norte","operado": "Norte","canal": "Norte","sucursal": "Norte","fechaRegistro": "14/05/2016","horaRegistro": "15:25","authTeso": "56416","status":""}}}}';
                        $response=json_decode($detalle,true);
                        return $response['DetalleTransaccionTipo']['transaction'];
                    }
                    if($type==6){
                        $detalle='{"DetalleTransaccionTipo":{"transaction":{"1256":{"idT24": "1256","noCheque": "51651857","ctaRetiro": "14256985","bancoCheque": "Bancomer","importeTx": "$34.00","operado": "Norte","sucursal": "Norte","fechaRegistro": "14/05/2016","horaRegistro": "15:25"}}}}';
                        $response=json_decode($detalle,true);
                        return $response['DetalleTransaccionTipo']['transaction'];
                    }
                    if($type==7){
                        $detalle='{"DetalleTransaccionTipo":{"transaction":{"1256":{"idT24": "1256","noCheque": "51651857","importe": "$256.50","operado": "Norte","sucursal": "Norte","fechaPago": "14/05/2016","horaPago": "15:25","status": "Pagado","motivoRechazo": ""}}}}';
                        $response=json_decode($detalle,true);
                        return $response['DetalleTransaccionTipo']['transaction'];
                    }
                    if($type==8){
                        $detalle='{"DetalleTransaccionTipo":{ "transaction":{"145":{"id":"145","fechaTx":"14-05-2016","importe": "$256.50", "tipoTx": "Compra",'
                                . '"comercio": "comercio1", "giro": "giro1", "pem": "pem", "referencia": "referencia1", "horaTx": "15:25", "respuesta": "response1", "motivoRechazo": "motivo1", "noAuth": "11", "afiliacion": "afiliacion1", "secuencia": "0001", "respArqueo": "respuestaarqueo1"}}}}';
                        $response=json_decode($detalle,true);
                        return $response['DetalleTransaccionTipo']['transaction'];
                    }
                    
			
		}
                
		
	}
        
        public function getBranchesWs(){
		if(!$this->getDevelopmentMode() || $this->getDevelopmentMode()==''){
                        $uri="DatosSucursalIntranet/";
                        $datos=$this->peticion($uri);
                        return $datos['datosSucursalIntranet'];
		}else{
			$file='{"datosSucursalIntranet":{ "datosSucursales":{"2":{"idBam": "2","nombreSucursal": "Norte", "estado": "1","domicilio": "Insurgentes norte No. 24 Col. Insurgentes norte ", "horarios": "De Lunes a Viernes de 09:00 a 18:00 y Sabados de 09:00 a 14:00", "estatus": "1"},"3": {"idBam": "3","nombreSucursal": "Sur", "estado": "2", "domicilio": "Insurgentes sur No. 4 Col. Insurgentes sur ", "horarios": "De Lunes a Viernes de 09:00 a 18:00 y Sabados de 09:00 a 14:00", "estatus": "2"}}}}';
                        $branches=json_decode($file,true);
		}
               
		return $branches['datosSucursalIntranet']['datosSucursales'];
	}
        
        public function getDetailTransactionId($idTransaction){
		if(!$this->getDevelopmentMode() || $this->getDevelopmentMode()==''){
                        $uri="DetalleTransaccionId/".$idTransaction;
                        $datos=$this->peticion($uri);
                        return $datos['detalleTransaccionId'];
		}else{
//			$file='{"datosSucursalIntranet":{ "datosSucursales":{"2":{"idBam": "2","nombreSucursal": "Norte", "estado": "1","domicilio": "Insurgentes norte No. 24 Col. Insurgentes norte ", "horarios": "De Lunes a Viernes de 09:00 a 18:00 y Sabados de 09:00 a 14:00", "estatus": "1"},"3": {"idBam": "3","nombreSucursal": "Sur", "estado": "2", "domicilio": "Insurgentes sur No. 4 Col. Insurgentes sur ", "horarios": "De Lunes a Viernes de 09:00 a 18:00 y Sabados de 09:00 a 14:00", "estatus": "2"}}}}';
//                        $branches=json_decode($file,true);
		}
               
		return $branches['datosSucursalIntranet']['datosSucursales'];
	}
	
	/*
	 * Metodo que se encarga del web service de productos de una cuenta
	 * @return ClientProductCollection;
	 * @param string account;
	 */
	public function getProductInformation($clientAccount){
		$clientProductCollection = new ProdCollection();
		$fields= array();
		if(!$this->getDevelopmentMode()){
			$uri="ProductosCuenta/".$clientAccount;
            $datos=$this->peticion($uri);
                        $i=1;
                        foreach($datos['productosCuenta']['productos'] as $key=>$data){
  //                        $fields['id_product']     = $i;
						  $fields['name']           = $data['nombreProducto'];
						  $fields['id_bam'] 		= $data['idBam'];
//						  $fields['no_tarjeta'] 	= "2569368958692536".$i;
//						  $fields['requirements']   = "Requerimiento".$i;					
						  $clientProducts = new Prod();
					     ProdFactory::populate($clientProducts, $fields);
					    $clientProductCollection->append($clientProducts);
                        $i++;
                        }
                    
		}else{
                   $i=1;
			$results = $this->getExampleClientProducts();
			if (!isset($results[0]->error) && is_array($results)){
				foreach ($results as $result){
					$fields['name']    		  = $result->getName();
					$fields['id_bam']         = $result->getIdBam();
					$fields['no_tarjeta'] 	  = $result->getNoTarjeta();
					$i++;
					$clientProducts = new Prod();
					ProdFactory::populate($clientProducts, $fields);
					$clientProductCollection->append($clientProducts);
				}				
			}
		}				
		return $clientProductCollection;
	}
	
	
	/**
	 * @return ClientAccountCollection
	 * @param string $clientNumber
	 */
	
	public function getAccountInformation($clientNumber){
		$fields = array();
		$clientAccountCollection = new ClientAccountCollection ();
		if(!$this->getDevelopmentMode()){	
			$uri="CuentasCliente/$clientNumber";
//          $datos=json_decode(file_get_contents($uri),true);
            $datos=$this->peticion($uri);
            if($datos['error'])
            	return $datos;
            
            foreach($datos['cuentasCliente']['cuentas'] as $data1){
            	foreach($data1 as $key =>$data){
                	$fields['account'] = $data1[$key]['noCuenta'];
                    $fields['type']    = $data1[$key]['tipoCuenta'];
                    $fields['card_number']= $data1[$key]['tarjeta'];
                    $clientAccount = new ClientAccount();
                    ClientAccountFactory::populate($clientAccount, $fields);					
                    $clientAccountCollection->append($clientAccount);
                }
			}
		}else{
            $results = $this->getExampleClientAccount();
			if (!isset($results[0]->error) && is_array($results)){
				foreach ($results as $result){				
					$fields['account'] = $result->getAccount();
					$fields['type']    = $result->getType();
					$fields['card_number']= $result->getCardNumber();
					$clientAccount = new ClientAccount();
					ClientAccountFactory::populate($clientAccount, $fields);					
					$clientAccountCollection->append($clientAccount);
				}
			}
		}
		return $clientAccountCollection;
	}
	

	public function getTransactionIdInformation($idTransaction){
		$transactionsCollection = new TransactionsCollection();
		if(!$this->getDevelopmentMode()){
			//definiciond el web service
		}else{
			$transactionsCollection = $this->getExampleClientIdTransactions();
		}
		return $transactionsCollection;
	}
	
	
	public function getTransactionInformation($clientNumber, $clientAccount,$fechaInicio,$fechaFin, $idProd){
		$fields = array();
		$transactionsCollection = new TransactionsCollection();
		if(!$this->getDevelopmentMode()){
			$fechaInicio=  str_replace("-","",substr($fechaInicio,0,10));
            $fechaFin=  str_replace("-","",substr($fechaFin,0,10));
            $uri="TransaccionesCliente/noCuenta=$clientAccount|fechaIni=$fechaInicio|fechaFin=$fechaFin|prod=$idProd";
            $datos=$this->peticion($uri);
            if($datos['error']){
            	return $datos;
            }
            else{
            	foreach($datos['transaccionesCliente'] as $key=>$result){
                	$fields['id_transaction']   = $result['idBam'];
                    $fields['transaction_date'] = $result['fechaTx'];
                    $fields['post_date']        = $result['fechaPosteo'];
                    $fields['descriptions']     = $result['descripcion']; 
                    $fields['reference_number'] = $result['noReferencia']; 
                    $fields['amount']	    	= $result['monto']; 
                    $fields['id_type_transaction'] = $result['tipo'];
        			$fields['comerce']		    = $result['comercio'];  
        			$fields['reference']	    = $result['referecnia']; 
        			$fields['afilition']	    = $result['ailiacion'];
                    $transaction = new Transactions();
                    TransactionsFactory::populate($transaction, $fields);					
                    $transactionsCollection->append($transaction);
				}
			}
		}else{
			$results = $this->getExampleClientTransactions();
			if (!isset($results[0]->error) && is_array($results)){
				foreach ($results as $result){
					$fields['id_transaction']   = $result->getIdTransaction();
					$fields['transaction_date'] = $result->getTransactionDate(); 
					$fields['post_date']        = $result->getPostDate(); 
					$fields['descriptions']     = $result->getDescriptions(); 
					$fields['reference_number'] = $result->getReferenceNumber(); 
					$fields['amount']	    	= $result->getAmount(); 
					$fields['id_type_transaction'] = $result->getIdTypeTransaction(); 
					$fields['giro']             = $result->getGiro();  
					$fields['comerce']	    	= $result->getComerce(); 
					$fields['pem']		    	= $result->getPem(); 
					$fields['reference']	    = $result->getReference(); 
					$fields['time_tx']	    	= $result->getTimeTx(); 
					$fields['answer']	    	= $result->getAnswer(); 
					$fields['id_reason']	    = $result->getIdReason(); 
					$fields['authorization_number'] = $result->getAuthorizationNumber(); 
					$fields['afilition']	    = $result->getAfilition(); 
					$fields['sequence']	    	= $result->getSequence(); 
					$fields['response']	    	= $result->getResponse(); 					
					$transaction = new Transactions();
					TransactionsFactory::populate($transaction, $fields);					
					$transactionsCollection->append($transaction);
				}
			}
		}
		return $transactionsCollection;
	}
	
	
	
	public function getTransactionInformationNumber($clientAccount, $idProd, $noMovments){
		$fields = array();
		$transactionsCollection = new TransactionsCollection();
		if(!$this->getDevelopmentMode()){
			$uri="TransaccionesClienteNumero/noCuenta=$clientAccount|prod=$idProd|movs=$noMovments";
			$datos=$this->peticion($uri);
			if($datos['error'])
				return $datos;
				else{
					if(count(transaccionesClienteNumero)>0){
						foreach($datos['transaccionesClienteNumero'] as $key=>$result){
							$fields['id_transaction']   = $result['idBam'];
							$fields['transaction_date'] = $result['fechaTx'];
							$fields['post_date']        = $result['fechaPosteo'];
							$fields['descriptions']     = $result['descripcion'];
							$fields['reference_number'] = $result['noReferencia'];
							$fields['amount']	    	= $result['monto'];
							$fields['id_type_transaction'] = $result['tipo'];
	// 						$fields['comerce']		    = $result['comercio'];
	// 						$fields['reference']	    = $result['referecnia'];
	// 						$fields['afilition']	    = $result['ailiacion'];
							$transaction = new Transactions();
							TransactionsFactory::populate($transaction, $fields);
							$transactionsCollection->append($transaction);
						}
					}
				}
		}else{
			$results = $this->getExampleClientTransactions();
			if (!isset($results[0]->error) && is_array($results)){
				foreach ($results as $result){
					$fields['id_transaction']   = $result->getIdTransaction();
					$fields['transaction_date'] = $result->getTransactionDate();
					$fields['post_date']        = $result->getPostDate();
					$fields['descriptions']     = $result->getDescriptions();
					$fields['reference_number'] = $result->getReferenceNumber();
					$fields['amount']	    	= $result->getAmount();
					$fields['id_type_transaction'] = $result->getIdTypeTransaction();
					$fields['giro']             = $result->getGiro();
					$fields['comerce']	    	= $result->getComerce();
					$fields['pem']		    	= $result->getPem();
					$fields['reference']	    = $result->getReference();
					$fields['time_tx']	    	= $result->getTimeTx();
					$fields['answer']	    	= $result->getAnswer();
					$fields['id_reason']	    = $result->getIdReason();
					$fields['authorization_number'] = $result->getAuthorizationNumber();
					$fields['afilition']	    = $result->getAfilition();
					$fields['sequence']	    	= $result->getSequence();
					$fields['response']	    	= $result->getResponse();
					$transaction = new Transactions();
					TransactionsFactory::populate($transaction, $fields);
					$transactionsCollection->append($transaction);
				}
			}
		}
		return $transactionsCollection;
	}
	/**
	 *
	 * Activar modo de desarrollo para evitar traer informacion del web service, la variable es mode y esta en el webconfig
	 */
	public function activateDevelopmentMode(){
		$this->developmentMode = true;
	}
	
	
	public function getDevelopmentMode(){
		return $this->webConfig->mode;
	}
	
	/**
	 * Devuelve un objeto para trabajar durante el modo desarrollo
	 * @author Luis Hernandez
	 * @return \Application\Model\Bean\ClientData
	 */
	private function getExampleClientData(){
		$clientData = new ClientData();
		$clientData->setBirthday('11/DIC/1975');
		$clientData->setClientNumber('123123');
		$clientData->setColony('Los Reyes Iztacala');
		$clientData->setExternalNumber('48');
		$clientData->setHomePhone('(55)53908078');
		$clientData->setInternalNumber('A');
		$clientData->setMobilePhone('(55)37270124');
		$clientData->setName('LUIS ANTONIO HERNANDEZ NIETO');
		$clientData->setOfficePhone('(55)55658733');
		$clientData->setRfc('HENL751211');
		$clientData->setState('MX');
		$clientData->setStreet('SAUCE 48');
		$clientData->setTown('TLALNEPANTLA');
		$clientData->setZipCode('54090');
		$clientData->setEmail('lciencias@yahoo.com.mx');
		$clientData->setEmployee(1);
		$clientData->setCardType(1);
		$clientData->setIdBranch('1');
		return $clientData;
	}
	/**
	 * Devuelve un objeto para trabajar durante el modo desarrollo
	 * @author Luis Hernandez
	 * @return \Application\Model\Bean\ClientAccount
	 */
	private function getExampleClientAccount(){
		$arrayClientAccount = array();
		$clientAccount = new ClientAccount();
		$clientAccount->setAccount('987987987900');
		$clientAccount->setCardNumber('5488256968690001');
		$clientAccount->setType('1');
		
		$clientAccount1 = new ClientAccount();
		$clientAccount1->setAccount('987987987901');
		$clientAccount1->setCardNumber('5488256968690002');
		$clientAccount1->setType('2');

		$clientAccount2 = new ClientAccount();
		$clientAccount2->setAccount('987987987902');
		$clientAccount2->setCardNumber('5488256968690003');
		$clientAccount2->setType('3');
		
		$arrayClientAccount[] = $clientAccount;
		$arrayClientAccount[] = $clientAccount1;
		$arrayClientAccount[] = $clientAccount2;
		return $arrayClientAccount;

	}
	
	private function getExampleClientTransactions(){
		$arrayTransactions = array();
		$transaction1 = new Transactions();
		$transaction1->setIdTransaction(1);
		$transaction1->setTransactionDate('22-11-2016'); 
		$transaction1->setPostDate('23-11-2016');
		$transaction1->setDescriptions("Test de transaction 1");
		$transaction1->setReferenceNumber("LTE117799663355");
		$transaction1->setAmount(105690);
		$transaction1->setIdTypeTransaction(1); 
		$transaction1->setGiro("test de giro"); 
		$transaction1->setComerce("Comerce");
		$transaction1->setPem("Test de PEM"); 
		$transaction1->setReference("Test de referecnia"); 
		$transaction1->setTimeTx("test de time tx"); 
		$transaction1->setAnswer("Test de respuesta");
		$transaction1->setIdReason(2); 
		$transaction1->setAuthorizationNumber(212121213); 
		$transaction1->setAfilition("21212132123"); 
		$transaction1->setSequence(12312132); 
		$transaction1->setResponse("Respuesta");
		
		
		$transaction2 = new Transactions();
		$transaction2->setIdTransaction(2);
		$transaction2->setTransactionDate('18-11-2016');
		$transaction2->setPostDate('19-11-2016');
		$transaction2->setDescriptions("Test de transaction 2");
		$transaction2->setReferenceNumber("LTE779966332211");
		$transaction2->setAmount(96580);
		$transaction2->setIdTypeTransaction(2);
		$transaction2->setGiro("test de giro");
		$transaction2->setComerce("Comerce");
		$transaction2->setPem("Test de PEM");
		$transaction2->setReference("Test de referecnia");
		$transaction2->setTimeTx("test de time tx");
		$transaction2->setAnswer("Test de respuesta");
		$transaction2->setIdReason(2);
		$transaction2->setAuthorizationNumber(212121213);
		$transaction2->setAfilition("21212132123");
		$transaction2->setSequence(12312132);
		$transaction2->setResponse("Respuesta");
		
		
		$transaction3 = new Transactions();
		$transaction3->setIdTransaction(3);
		$transaction3->setTransactionDate('15-11-2016');
		$transaction3->setPostDate('16-11-2016');
		$transaction3->setDescriptions("Test de transaction 3");
		$transaction3->setReferenceNumber("LTE889695364242");
		$transaction3->setAmount(78200);
		$transaction3->setIdTypeTransaction(3);
		$transaction3->setGiro("test de giro");
		$transaction3->setComerce("Comerce");
		$transaction3->setPem("Test de PEM");
		$transaction3->setReference("Test de referecnia");
		$transaction3->setTimeTx("test de time tx");
		$transaction3->setAnswer("Test de respuesta");
		$transaction3->setIdReason(2);
		$transaction3->setAuthorizationNumber(212121213);
		$transaction3->setAfilition("21212132123");
		$transaction3->setSequence(12312132);
		$transaction3->setResponse("Respuesta");
		
		$transaction4 = new Transactions();
		$transaction4->setIdTransaction(4);
		$transaction4->setTransactionDate('15-11-2016');
		$transaction4->setPostDate('16-11-2016');
		$transaction4->setDescriptions("Test de transaction 4");
		$transaction4->setReferenceNumber("LTE889695364242");
		$transaction4->setAmount(78200);
		$transaction4->setIdTypeTransaction(4);
		$transaction4->setGiro("test de giro");
		$transaction4->setComerce("Comerce");
		$transaction4->setPem("Test de PEM");
		$transaction4->setReference("Test de referecnia");
		$transaction4->setTimeTx("test de time tx");
		$transaction4->setAnswer("Test de respuesta");
		$transaction4->setIdReason(2);
		$transaction4->setAuthorizationNumber(212121213);
		$transaction4->setAfilition("21212132123");
		$transaction4->setSequence(12312132);
		$transaction4->setResponse("Respuesta");
		
		$transaction5 = new Transactions();
		$transaction5->setIdTransaction(5);
		$transaction5->setTransactionDate('15-11-2016');
		$transaction5->setPostDate('16-11-2016');
		$transaction5->setDescriptions("Test de transaction 5");
		$transaction5->setReferenceNumber("LTE889695364242");
		$transaction5->setAmount(78200);
		$transaction5->setIdTypeTransaction(5);
		$transaction5->setGiro("test de giro");
		$transaction5->setComerce("Comerce");
		$transaction5->setPem("Test de PEM");
		$transaction5->setReference("Test de referecnia");
		$transaction5->setTimeTx("test de time tx");
		$transaction5->setAnswer("Test de respuesta");
		$transaction5->setIdReason(2);
		$transaction5->setAuthorizationNumber(212121213);
		$transaction5->setAfilition("21212132123");
		$transaction5->setSequence(12312132);
		$transaction5->setResponse("Respuesta");
		
		$transaction6 = new Transactions();
		$transaction6->setIdTransaction(6);
		$transaction6->setTransactionDate('15-11-2016');
		$transaction6->setPostDate('16-11-2016');
		$transaction6->setDescriptions("Test de transaction 6");
		$transaction6->setReferenceNumber("LTE889695364242");
		$transaction6->setAmount(78200);
		$transaction6->setIdTypeTransaction(6);
		$transaction6->setGiro("test de giro");
		$transaction6->setComerce("Comerce");
		$transaction6->setPem("Test de PEM");
		$transaction6->setReference("Test de referecnia");
		$transaction6->setTimeTx("test de time tx");
		$transaction6->setAnswer("Test de respuesta");
		$transaction6->setIdReason(2);
		$transaction6->setAuthorizationNumber(212121213);
		$transaction6->setAfilition("21212132123");
		$transaction6->setSequence(12312132);
		$transaction6->setResponse("Respuesta");
		
		$transaction7 = new Transactions();
		$transaction7->setIdTransaction(7);
		$transaction7->setTransactionDate('15-11-2016');
		$transaction7->setPostDate('16-11-2016');
		$transaction7->setDescriptions("Test de transaction 7");
		$transaction7->setReferenceNumber("LTE889695364242");
		$transaction7->setAmount(78200);
		$transaction7->setIdTypeTransaction(7);
		$transaction7->setGiro("test de giro");
		$transaction7->setComerce("Comerce");
		$transaction7->setPem("Test de PEM");
		$transaction7->setReference("Test de referecnia");
		$transaction7->setTimeTx("test de time tx");
		$transaction7->setAnswer("Test de respuesta");
		$transaction7->setIdReason(2);
		$transaction7->setAuthorizationNumber(212121213);
		$transaction7->setAfilition("21212132123");
		$transaction7->setSequence(12312132);
		$transaction7->setResponse("Respuesta");
		
		$transaction8 = new Transactions();
		$transaction8->setIdTransaction(8);
		$transaction8->setTransactionDate('15-11-2016');
		$transaction8->setPostDate('16-11-2016');
		$transaction8->setDescriptions("Test de transaction 8");
		$transaction8->setReferenceNumber("LTE889695364242");
		$transaction8->setAmount(78200);
		$transaction8->setIdTypeTransaction(1);
		$transaction8->setGiro("test de giro");
		$transaction8->setComerce("Comerce");
		$transaction8->setPem("Test de PEM");
		$transaction8->setReference("Test de referecnia");
		$transaction8->setTimeTx("test de time tx");
		$transaction8->setAnswer("Test de respuesta");
		$transaction8->setIdReason(2);
		$transaction8->setAuthorizationNumber(212121213);
		$transaction8->setAfilition("21212132123");
		$transaction8->setSequence(12312132);
		$transaction8->setResponse("Respuesta");
		
		$arrayTransactions[0] = $transaction1;
		$arrayTransactions[1] = $transaction2;
		$arrayTransactions[2] = $transaction3;
		$arrayTransactions[3] = $transaction4;
		$arrayTransactions[4] = $transaction5;
		$arrayTransactions[5] = $transaction6;
		$arrayTransactions[6] = $transaction7;
		$arrayTransactions[7] = $transaction8;		
		return $arrayTransactions;
	}

	private function getExampleClientIdTransactions(){
		//$arrayTransactions = array();
		$transaction1 = new Transactions();
		$transaction1->setIdTransaction(1);
		$transaction1->setTransactionDate('22-11-2016');
		$transaction1->setPostDate('23-11-2016');
		$transaction1->setDescriptions("Test de transaction 1");
		$transaction1->setReferenceNumber("LTE117799663355");
		$transaction1->setAmount(105690);
		$transaction1->setIdTypeTransaction(4);
		$transaction1->setGiro("test de giro");
		$transaction1->setComerce("Comerce");
		$transaction1->setPem("Test de PEM");
		$transaction1->setReference("Test de referecnia");
		$transaction1->setTimeTx("test de time tx");
		$transaction1->setAnswer("Test de respuesta");
		$transaction1->setIdReason(2);
		$transaction1->setAuthorizationNumber(212121213);
		$transaction1->setAfilition("21212132123");
		$transaction1->setSequence(12312132);
		$transaction1->setResponse("Respuesta");
		//$arrayTransactions[0] = $transaction1;
		return $transaction1;
	}
	
	private function getExampleClientProducts(){
		$arrayProducts = array();

		$product1  = new Prod(); 
		$product1->setIdBam(1);		
		$product1->setNoTarjeta("5566997785691256");
		$product1->setName("Banca Electronica");
		
		$product2  = new Prod();
		$product2->setName("Cheques");
		$product2->setIdBam(2);
		$product2->setNoTarjeta("1425986535274856");
		
		$product3  = new Prod();
		$product3->setName("Tarjeta de Debito");
		$product3->setIdBam(3);
		$product3->setNoTarjeta("14796854695371426");
		
		$product4  = new Prod();
		$product4->setIdBam(4);
		$product4->setName("Banca Electronica");
		$product4->setNoTarjeta("5566997785691256");
		
		$product5  = new Prod();
		$product5->setIdBam(5);
		$product5->setName("Cheques");
		$product5->setNoTarjeta("1425986535274856");
		
		$product6  = new Prod();
		$product6->setIdBam(6);
		$product6->setName("Tarjeta de Debito");		
		$product6->setNoTarjeta("14796854695371426");
		
		$product7  = new Prod();
		$product7->setIdBam(7);
		$product7->setName("Banca Electronica");
		$product7->setNoTarjeta("5566997785691256");
		
		$product8  = new Prod();
		$product8->setIdBam(8);
		$product8->setName("Cheques");
		$product8->setNoTarjeta("1425986535274856");
			
		$arrayProducts[] = $product1;
		$arrayProducts[] = $product2;
		$arrayProducts[] = $product3;
		$arrayProducts[] = $product4;
		$arrayProducts[] = $product5;
		$arrayProducts[] = $product6;
		$arrayProducts[] = $product7;
		$arrayProducts[] = $product8;		
		return $arrayProducts;
	}
	
	
	
	/**Devuelve un objeto para trabajar durante el modo desarrollo
	 * @autor Luis Hernandez
	 * @return \Application\Model\Bean\ClientProduct
	 */
	
	private function getExampleClienteProduct(){
		$arrayClientProduct = array();
		$clientProduct = new ClientProduct();
	}
}

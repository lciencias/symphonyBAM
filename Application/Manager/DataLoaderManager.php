<?php 

/**
 *
 * Manager para cargar la información a la base de datos desde un archivo excel
 * @author joseluis
 **/
class DataLoaderManager {
	/**
	 * nombre de la hoja de excel para las sucursales
	 */
	const BRANCH_SHEET = 'sucursales';
	/**
	 * nombre de la hoja de excel para los canales
	 */
	const CHANNEL_SHEET = 'canales';
	/**
	 * nombre de la hoja de excel para las sucursales
	 */
	const COMPANY_SHEET = 'empresas';
	/**
	 * nombre de la hoja de excel para los escalamentos
	 */
	const ESCALATION_SHEET = 'escalamientos';
	/**
	 * nombre de la hoja de excel para los impactos
	 */
	const IMPACT_SHEET = 'impactos';
	/**
	 * nombre de la hoja de excel para las resoluciones
	 */
	const RESOLUTION_SHEET = 'resoluciones';
	/**
	 * nombre de la hoja de excel para los niveles de servicio
	 */
	const SERVICE_LEVEL_SHEET = 'niveles de servicio';
	/**
	 * nombre de la hoja de excel para los tipos de ticket
	 */
	const TICKET_TYPE_SHEET = 'tipos de ticket';
	/**
	 * nombre de la hoja de excel para las areas
	 */
	const AREA_SHEET = 'areas';
	/**
	 * nombre de la hoja de excel para las ubicaciones
	 */
	const LOCATION_SHEET = 'ubicaciones';
	/**
	 * nombre de la hoja de excel para las posiciones
	 */
	const POSITION_SHEET = 'posiciones ';
	/**
	 * nombre de la hoja de excel para los empleados
	 */
	const EMPLOYEE_SHEET = 'empleados';
	/**
	 * nombre de la hoja de excel para los grupos
	 */
	const GROUP_SHEET = 'grupos';
	/**
	 * nombre de la hoja de excel para las categorias
	 */
	const CATEGORY_SHEET = 'categorias';
	/**
	 *
	 * @var PHPExcel
	 */
	private $file;
	/**
	 * Los campos como se encuentran en el archivo de carga inicial mapeados con su campo en la base de datos
	 * @var array
	 */
	private static $branchFields = array(
			'Estado',
			'Nombre',
	);

	/**
	 * Los campos como se encuentran en el archivo de carga inicial mapeados con su campo en la base de datos
	 * @var array
	 */
	private static $channelFields = array(
			'Nombre',
	);
	/**
	 * Los campos como se encuentran en el archivo de carga inicial mapeados con su campo en la base de datos
	 * @var array
	 */
	private static $companyFields = array(
			'Nombre',
	);
	/**
	 * Los campos como se encuentran en el archivo de carga inicial mapeados con su campo en la base de datos
	 * @var array
	 */
	private static $escalationFields = array(
			'Nombre',
	);
	/**
	 * Los campos como se encuentran en el archivo de carga inicial mapeados con su campo en la base de datos
	 * @var array
	 */
	private static $impactFields = array(
			'Nombre',
	);
	/**
	 * Los campos como se encuentran en el archivo de carga inicial mapeados con su campo en la base de datos
	 * @var array
	 */
	private static $resolutionFields = array(
			'Nombre',
			'Tipo',
	);
	/**
	 * Los campos como se encuentran en el archivo de carga inicial mapeados con su campo en la base de datos
	 * @var array
	 */
	private static $serviceLevelFields = array(
			'Nombre',
			'Tiempo de Resolucion',
			'Tiempo de Respuesta',
			'Nota',
	);
	/**
	 * Los campos como se encuentran en el archivo de carga inicial mapeados con su campo en la base de datos
	 * @var array
	 */
	private static $ticketTypeFields = array(
			'Nombre',
	);
	/**
	 * Los campos como se encuentran en el archivo de carga inicial mapeados con su campo en la base de datos
	 * @var array
	 */
	private static $areaFields = array(
			'Empresa',
			'Nombre',
	);
	/**
	 * Los campos como se encuentran en el archivo de carga inicial mapeados con su campo en la base de datos
	 * @var array
	 */
	private static $locationfields = array(
			'Empresa',
			'Nombre',
	);
	/**
	 * Los campos como se encuentran en el archivo de carga inicial mapeados con su campo en la base de datos
	 * @var array
	 */
	private static $positionFields = array(
			'Nombre',
			'Empresa',
	);
	/**
	 * Los campos como se encuentran en el archivo de carga inicial mapeados con su campo en la base de datos
	 * @var array
	 */
	private static $EmployeeFields = array(
			'Area',
			'Empresa',
			'Ubicacion',
			'Posicion',
			'Apellido Paterno',
			'Apellido Materno',
			'Nombre',
	);
	/**
	 * Los campos como se encuentran en el archivo de carga inicial mapeados con su campo en la base de datos
	 * @var array
	 */
	private static $groupFields = array(
			'Responsable',
			'Horario',
			'Nombre',
			'Asignar tickets a',
	);
	/**
	 * Los campos como se encuentran en el archivo de carga inicial mapeados con su campo en la base de datos
	 * @var array
	 */
	private static $categoryFields = array(
			'Empresa',
			'Nombre',
			'Grupo',
			'Escalamiento',
			'Padre',
			'Nivel de Servicio',
			'Nota'
	);
	/**
	 * Las tablas que seran cargadas
	 * @var unknown_type
	 */
	private $dataToBeLoaded = array();
	/**
	 *
	 * @param PHPExcel $file el archivo que se utilizara para la carga de datos
	 */
	public function __construct(PHPExcel $file){
		$this->setFile($file);
	}

	public function loadData(){
		foreach ($this->getDataToBeLoaded() as $table){
			switch ($table) {
// 				case self::BRANCH_SHEET:
// 					break;
// 				case self::AREA_SHEET:
// 					break;
// 				case self::CATEGORY_SHEET:
// 					break;
// 				case self::CHANNEL_SHEET:
// 					reak;
// 				case self::COMPANY_SHEET:
// 					break;
// 				case self::EMPLOYEE_SHEET:
// 					break;
// 				case self::ESCALATION_SHEET:
// 					break;
// 				case self::GROUP_SHEET:
// 					break;
// 				case self::IMPACT_SHEET:
// 					break;
// 				case self::LOCATION_SHEET:
// 					break;
// 				case self::POSITION_SHEET:
// 					break;
// 				case self::RESOLUTION_SHEET:
// 					break;
// 				case self::SERVICE_LEVEL_SHEET:
// 					break;
// 				case self::TICKET_TYPE_SHEET:
// 					break;
				
			}
		}
	}
	
	private function sucursales(){
		$file = $this->getFile();
		$sheet = $file->getSheetByName();
		if ($sheet){
				
		}else {
			throw new Exception('No se pudo encontrar la hoja');
		}
	}
	/**
	 * Agrega un 	
	 * @param array $dataToBeLoaded
	 * @return DataLoaderManager
	 */
	public function setDataToBeLoaded($dataToBeLoaded){
		$this->dataToBeLoaded = $dataToBeLoaded;
		return $this;
	}
	/**
	 *
	 * @return array
	 */
	public function getDataToBeLoaded(){
		return $this->dataToBeLoaded;
	}
	/**
	 *
	 * Mapea las columnas del archivo con los campos del array sino coinciden todos mandara una excepción
	 * @param PHPExcel_Worksheet $sheet
	 * @param array $fields
	 */
	private function mapColumnWithField(PHPExcel_Worksheet $sheet,array $fields){
		$lastColumn = $sheet->getHighestColumn();
		$fieldsTotal = count($fields);
		$row = $sheet->rangeToArray('A1',$lastColumn.'1');
		echo '<pre>';
		print_r($row);
		die;
	}
	/**
	 *
	 * @param PHPExcel $file
	 * @return DataLoaderManager
	 */
	public function setFile($file){
		$this->file = $file;
		return $this;
	}
	/**
	 * @return PHPExcel
	 */
	public function getFile(){
		return $this->file;
	}
	
}
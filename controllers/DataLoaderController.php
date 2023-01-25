<?php 

/**
  *
  * @author joseluis
  **/
use Application\File\FileUploader;

use Application\Controller\BaseController;

class DataLoaderController extends BaseController{
	/**
	 * 
     * @module DataLoader
     * @action Upload
	 */
	public function indexAction() {
		$now = new Zend_Date();
		if ($this->getRequest()->isPost()){
			$tempFile = $this->saveTempFile('file');
			$phpExcel = $this->loadPhpExcel($filePath);
			$dataloaderManager = new DataLoaderManager($phpExcel);
// 			$dataloaderManager->
			
		}
	}
	/**
	 * 
	 * Guarda el archivo en la carpeta de temporales. Regresa el nombre del archivo cargado o falso 
	 * @param string $fileField
	 * @throws Exception
	 * @return string|boolean 
	 */
	private function saveTempFile($fileField){
		
		$mimeType = $_FILES[$fileField]['type'];
		$fileUploader = new FileUploader($fileField);
		try{
			if($this->checkMimeTypes($mimeType)){
				$uploadPath = '/tmp/';
				$fileUploader->saveFile($uploadPath, false);
				
			}else{
				throw new  Exception('El archivo debe de ser excel');
			}
		}catch(Exception $e){
			echo '<pre>';
			print_r($_FILES);
			die;
			throw $e;
		}
		return $fileUploader->getFileName();
	}
	/**
	 * Carga un archivo excel desde una ubicación
	 * @param string $tempFile
	 * @throws Exception
	 * @return \PHPExcel
	 */
	private function loadPhpExcel($filePath){
		try {
			$fileType = PHPExcel_IOFactory::identify($tempFile);
			$reader = PHPExcel_IOFactory::createReader($fileType);
			$PHPExcel = $reader->load($tempFile);
			return $PHPExcel;
		} catch (Exception $e) {
			throw new Exception('No se puede cargar el archivo ');
		}
	}
	/**
	 * 
	 * @param string $mimeType
	 * @return boolean
	 */
	private function checkMimeTypes($mimeType){
		return in_array($mimeType, self::$mimeTypes);
	}
	/**
	 * Archivos soportados
	 * @var array
	 */
	private static $mimeTypes = array(
			'xls' => 'application/vnd.ms-excel',
			'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',

	);
} 
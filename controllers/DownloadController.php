<?php

use Application\Controller\BaseController;
use Application\Query\FileQuery;
use Application\Query\FileTmpQuery;

class DownloadController extends BaseController {
	var $pathDownload;	
	
	public function downloadAction(){
		$this->pathDownload   = \Zend_Registry::getInstance()->config->appSettings->path;
		$id 	  = $this->getRequest()->getParam('id');
		if($id > 0){	
			$files=  FileQuery::create()->findByPKOrThrow($id, $this->i18n->_("The File with id {$id} doesn't exist"));
			if( $files != null && (int) $id > 0){
				$tipo = $this->getType($files->getUri());
				$name = $this->getFilename($files->getUri());
				$this->downloadAutomatica($files->getUri(),$name,$tipo);
			}
		}
		$this->view->setTpl('Download')->setLayoutFile(false);
	}

	public function downloadTmpAction(){
		$this->pathDownload   = \Zend_Registry::getInstance()->config->appSettings->path;
		$id 	  = $this->getRequest()->getParam('id');
		if($id > 0){
			$files=  FileTmpQuery::create()->findByPKOrThrow($id, $this->i18n->_("The FileTmp with id {$id} doesn't exist"));
			if( $files != null && (int) $id > 0){
				$tipo = $this->getType($files->getUri());
				$name = $this->getFilename($files->getUri());
				$this->downloadAutomatica($files->getUri(),$name,$tipo);
			}
		}
		$this->view->setTpl('Download')->setLayoutFile(false);
	}
	
	public function downloadAutomatica($pathFile,$name,$tipo){	
		$pathFile = $this->pathDownload.$pathFile;
		if(file_exists($pathFile)){
			header('Content-Type:application/force-download');
			header('Content-Description:File Transfer');
			header('Pragma: public');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Cache-Control: private', false);
			header('Content-type: application/{$tipo}');
			header('Content-Disposition: attachment; filename="'.$name.'"');
			@readfile($pathFile);
		}
	}
	
	public function getType($filename){
		$array = explode(".",$filename);
		$lon   =  count($array);
		return $array[$lon - 1];
	}
	
	public function getFilename($filename){
		$array = explode("/",$filename);		
		$lon   =  count($array);
		return $array[$lon - 1];
		
	}	
}
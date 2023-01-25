<?php
/**
 * PCS Mexico / America
 *
 * LIPS Promotions
 *
 * @category   Project
 * @package    Lib_Managers
 * @copyright  Copyright (c) 2007-2010 PCS Mexico (http://www.pcsmexico.com)
 * @author     chente, $LastChangedBy$
 * @version    1.0, SVN:  $Id$
 */

namespace Application\File;

use Application\Model\Bean\FileTmp;

/**
 * Clase para Guardar los archivos que se envien desde un formulario
 *
 */
class FileUploader
{

    /**
     *
     * @var string $name
     */
    private $name;

    /**
     *
     * @var string
     */
    private $originalName;

    /**
     *
     * @var string
     */
    private $mimeType;

    /**
     *
     * @var float
     */
    private $size;

    /**
     *
     * @var string $fileName
     */
    private $fileName = '';

    /**
     * @var string $path
     */
    private $path;

    /**
     * Dimensiiones del thumbnail que se generará [W,H]
     * @var mixed
     */
    private $dimensions = array();


    /**
     * Constructor de la clase
     *
     * @param string $formName El nombre de la variable enviada al formulario
     */
    function __construct($formName)
    {
        $this->name = $formName;
        if($this->isUpload())
        {
            $this->mimeType = $_FILES[$this->name]['type'];
            $this->size = $_FILES[$this->name]['size'];
            $t = explode('.', basename($_FILES[$this->name]['name']));
            $this->originalName = $t[0].'-';
        }
    }

    /**
     * Indica si un archivo ha sido enviado al servidor
     * @param string $fileName El nombre de la variable post donde fue enviado el archivo
     * @return Boolean
     */
    public function isUpload()
    {
        if(!isset($_FILES[$this->name]) || !is_uploaded_file($_FILES[$this->name]['tmp_name']))
        {
            return false;
        }
        else
            return true;
    }

    /**
     * Guarda el archivo
     * @param string $path El directorio donde deseamos que se guarde nuestro archivo
     * @param string $resize Hace una copia miniatura del archivo si es una imagen y deja el original con un sufijo ' _o '
     * @return boolean
     * @throws Exception
     */
    public function saveFile($path, $resize = true)
    {
        if(!is_dir($path . $this->path))
        {
            if(!@mkdir($path . $this->path, 0777, true))
                throw new FileException('No se pudo crear el directorio destino, Compruebe que tiene los permisos suficientes en ' . $path .'');
        }

        $name = $this->cleanName($this->originalName) . substr(md5($path . time()), 0, 5) . ($resize ? '_o' : '');

        $this->fileName = $name. '.' . $this->getFileExtension();

        $file = $path . $this->path . '/' . $this->fileName;
        if(!move_uploaded_file($_FILES[$this->name]['tmp_name'], $file))
            throw new FileException('El archivo no se pudo mover a su destino');
        chmod($file, 0777);
        if($resize && in_array($this->mimeType, File::$mimeImages))
        {
            $imageResize = new ImageResizer($file, str_replace('_o', '', $file), 360, 480);
            $imageResize->getResizedImage();
            $this->fileName = str_replace('_o', '', $this->fileName);

            $imageResize = new ImageResizer($file, str_replace('_o', '_mini', $file), 120, 120);
            $imageResize->getResizedImage();
            $this->fileName = str_replace('_o', '', $this->fileName);
        }
        return true;
    }

    public function saveFileTmp($path, $resize = true)
    {
    	if(!is_dir($path . $this->path))
    	{
    		if(!@mkdir($path . $this->path, 0777, true))
    			throw new FileException('No se pudo crear el directorio destino, Compruebe que tiene los permisos suficientes en ' . $path .'');
    	}    
    	$name = $this->cleanName($this->originalName) . substr(md5($path . time()), 0, 5) . ($resize ? '_o' : '');
    	$this->fileName = $name. '.' . $this->getFileExtension();
    	$file = $path . $this->path . '/' . $this->fileName;    	
    	if(!move_uploaded_file($_FILES[$this->name]['tmp_name'], $file)){
    		throw new FileException('El archivo no se pudo mover a su destino');
    	}
    	chmod($file, 0777);
    	/*if($resize && in_array($this->mimeType, File::$mimeImages))
    	{    	
    		$imageResize = new ImageResizer($file, str_replace('_o', '', $file), 360, 480);
    		$imageResize->getResizedImage();
    		$this->fileName = str_replace('_o', '', $this->fileName);
    
    		$imageResize = new ImageResizer($file, str_replace('_o', '_mini', $file), 120, 120);
    		$imageResize->getResizedImage();
    		$this->fileName = str_replace('_o', '', $this->fileName);
    	}*/
    	return true;
    }
    
    /**
     *
     * @param string $str
     * @return string
     */
    public function cleanName( $str )
    {
        $cleaner = array();
        $cleaner[] = array('expression'=>"/[àáäãâª]/",'replace'=>"a");
        $cleaner[] = array('expression'=>"/[èéêë]/",'replace'=>"e");
        $cleaner[] = array('expression'=>"/[ìíîï]/",'replace'=>"i");
        $cleaner[] = array('expression'=>"/[òóõôö]/",'replace'=>"o");
        $cleaner[] = array('expression'=>"/[ùúûü]/",'replace'=>"u");
        $cleaner[] = array('expression'=>"/[ñ]/",'replace'=>"n");
        $cleaner[] = array('expression'=>"/[ç]/",'replace'=>"c");

        $str = strtolower($str);

        foreach( $cleaner as $cv ) $str = preg_replace($cv["expression"],$cv["replace"],$str);
        $str = str_replace('_o', '', $str);
        return preg_replace("/[^a-z0-9-]/", '_', $str);
    }

    /**
     * Obtiene el URI de la imagen para ser almacenado en la base de datos
     *
     * @return string
     */
    public function getFileName()
    {
        return ($this->fileName == '') ? '' : $this->path . '/' . $this->fileName;
    }

    /**
     * Nombre original del archivo
     *
     * @return string
     */
    public function getOriginalName()
    {

        return basename($_FILES[$this->name]['name']);;
    }

    /**
     * Obtiene la extensión del archivo seleccionado
     *
     * @param string $filepath
     * @return string
     */
    public function getFileExtension()
    {
        $info = pathinfo($_FILES[$this->name]['name']);
        return strtolower($info["extension"]);
    }

    /**
     *
     * @return boolean
     */
    public function isXlsxExtension(){
        return strtolower($this->getFileExtension()) == 'xlsx';
    }

    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return mixed
     */
    public function getDimensions()
    {
        return $this->dimensions;
    }

    /**
     * @param mixed $dimensions
     */
    public function setDimensions($dimensions)
    {
        $this->dimensions = $dimensions;
    }

    /**
     * @return the $mimeType
     */
    public function getMimeType ()
    {
        return $this->mimeType;
    }

    /**
     * @return the $size
     */
    public function getSize ()
    {
        return $this->size;
    }

    /**
     * @param $mimeType the $mimeType to set
     */
    public function setMimeType ($mimeType)
    {
        $this->mimeType = $mimeType;
    }

    /**
     * @param $size the $size to set
     */
    public function setSize ($size)
    {
        $this->size = $size;
    }

}

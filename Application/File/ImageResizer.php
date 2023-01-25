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

/**
 * Clase para hacer las redimensiones de las im�genes
 *
 */
class ImageResizer
{

    /**
     * Nombre de la imagen
     * @var string $imageName
     */
    private $imageName;

    /**
     * Nombre de la imagen destino
     * @var string $resizedImageName
     */
    private $resizedImageName;

    /**
     * Nuevo ancho m�ximo
     * @var int $newWidth
     */
    private $newWidth;

    /**
     * Nueva altura m�xima
     *
     * @var int $newHeight
     */
    private $newHeight;

    /**
     * La imagen origen
     *
     * @var source $imageSource
     */
    private $imageSource;

    /**
     * La imagen destino
     * @var resource $imageDestination
     */
    private $imageDestination;

    /**
     * Constructor de la clase ImageResizeJpeg
     *
     * @param string $imageName
     * @param string $resizedImageName
     * @param int $newWidth
     * @param height $newHeight
     * @return ImageResizeJpeg
     */
    public function ImageResizer($imageName, $resizedImageName, $newWidth, $newHeight)
    {
        $this->imageName = $imageName;
        $this->resizedImageName = $resizedImageName;
        $this->newWidth = $newWidth;
        $this->newHeight = $newHeight;
    }

    /**
     * El m�todo que redimensiona la imagen
     */
    private function resizeImage()
    {
        $oldWidth = imagesx($this->imageSource);
        $oldHeight = imagesy($this->imageSource);
        $imageRatio = $oldWidth / $oldHeight;

        if($oldWidth > $this->newWidth || $oldHeight > $this->newHeight)
        {
            if($imageRatio > 1)
            {
                $thumbWidth = $this->newWidth;
                $thumbHeight = $this->newWidth / $imageRatio;
            }
            else
            {
                $thumbHeight = $this->newHeight;
                $thumbWidth = $this->newHeight * $imageRatio;
            }
        }
        else
        {
            $thumbHeight = $oldHeight;
            $thumbWidth = $oldWidth;
        }

        $this->imageDestination = imagecreatetruecolor($thumbWidth, $thumbHeight);
        imagecopyresampled($this->imageDestination, $this->imageSource, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $oldWidth, $oldHeight);
    }

    /*
     * Guarda la imagen en destino especificado
     */
    public function getResizedImage()
    {
        $imageType = exif_imagetype($this->imageName);
        switch($imageType)
        {
            case IMAGETYPE_JPEG:
                $this->imageSource = imagecreatefromjpeg($this->imageName);
                $this->resizeImage();
                imagejpeg($this->imageDestination, $this->resizedImageName);
                break;
            case IMAGETYPE_GIF:
                $this->imageSource = imagecreatefromgif($this->imageName);
                $this->resizeImage();
                imagegif($this->imageDestination, $this->resizedImageName);
                break;
            case IMAGETYPE_PNG:
                $this->imageSource = imagecreatefrompng($this->imageName);
                $this->resizeImage();
                imagepng($this->imageDestination, $this->resizedImageName);
                break;
            default:
                throw new FileException('Tipo de Imagen no soportada');
                break;
        }
    }

}















<?php
/**
 * PCS Mexico
 *
 * Sistema de Control de Clubs
 *
 * @category   Lib
 * @package    Lib_Pdf
 * @copyright  Copyright (c) 2007-2010 PCS Mexico (http://www.pcsmexico.com)
 * @author     chente <vmendoza@pcsmexico.com>, $LastChangedBy: chente $
 * @version    1.1, SVN: $Id: PDF_Template.php 8 2009-09-08 16:13:10Z chente $
 */

namespace Application\Excel;

/**
 * \PHPExcel
 */
require_once 'PHPExcel.php';
require_once 'PHPExcel/IOFactory.php';

/**
 * Clase ReportExcel para crear reportes en excel
 *
 * @category   Lib
 * @package    Lib_Pdf
 * @copyright  Copyright (c) 2007-2010 PCS Mexico (http://www.pcsmexico.com)
 */
class ReportExcel extends \PHPExcel
{

    /**
     * Traductor
     * @var Zend_Traslate
     */
    protected $l10n = null;

    /**
     *
     * @var int
     */
    protected $defaultRowHeader = 4;

    /**
     * primera fila
     * @var int
     */
    protected $defaultRow = 5;

    /**
     *
     * @var \PHPExcel_Style
     */
    protected $styleBody = null;

    /**
     *
     * @var \PHPExcel_Style
     */
    protected $styleBodyOdd = null;

    /**
     * Header style
     * @var \PHPExcel_Style
     */
    protected $styleHeader = null;

    /**
     * Subheader style
     * @var \PHPExcel_Style
     */
    protected $styleSubheader = null;

    /**
     * Style Footer style
     * @var \PHPExcel_Style
     */
    protected $styleFooter = null;

    /**
     *
     * @var variable de loop
     */
    private $i = 2;

    /**
     *
     * @var array
     */
    private $abc = array( 0 => 'A','B','C','D','E','F','G','H','I','J','K','L','M','N',
        'O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH',
    );

    /**
     * estilo default de font
     * @var array
     */
    public $defaultFont = array(
        'name' => 'Arial',
        'size' => 10,
    );


    /**
     * Constructor
     * @param string $title
     * @param string $description
     * @param string $category
     * @param string $keywords
     * @return ReportExcel
     */
    public function __construct($title = 'title', $description = 'description', $category = 'category', $keywords = 'keywords')
    {
        parent::__construct();
        $this->getProperties()
            ->setCreator("PCS Mexico")
            ->setLastModifiedBy("PCS Mexico")
            ->setTitle($title)
            ->setSubject($title)
            ->setDescription($description)
            ->setKeywords($keywords)
            ->setCategory($category);
        $this->initStyles();
    }

    /**
     * set headers
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        foreach ($headers as $key => $header)
        {
            $this->getActiveSheet()->setCellValueExplicit($this->abc[$key].'1', (string) $header);
        }
    }

    /**
     * add values
     * @param array $values
     */
    public function addCustomRow(array $values)
    {
        $values = array_values($values);
        foreach ($values as $key => $value)
        {
            $this->getActiveSheet()->setCellValueExplicit($this->abc[$key].$this->i, (string) utf8_encode($value));
        }
        $this->i++;
    }

    /**
     * Envia el archivo al browser para descargarse
     * @param string $filename
     */
    public function toBrowser($basename = 'report', $extension = '.xlsx')
    {
        $filename = $basename . $extension;
        $this->setActiveSheetIndex(0);

        header('Content-type: application/octect-stream');
        header("Content-Disposition: attachment; filename={$filename}");
        header("Pragma: public");

        $objWriter = \PHPExcel_IOFactory::createWriter($this, $extension == '.xlsx' ?  'Excel2007' : 'Excel5');
        $objWriter->save('php://output');
        die();
    }
    
    /**
     * Envia el archivo al browser para descargarse
     * @param string $filename
     */
    public function toBrowser2($basename = 'report', $extension = '.xlsx')
    {
        $filename = $basename . $extension;
        $this->setActiveSheetIndex(0);
        header("Content-Type: application/vnd.ms-excel; charset=utf-8");
    		header("Content-type: application/x-msexcel; charset=utf-8");
    		header("Content-Disposition: attachment; filename=".$basename.".xlsx");
    		header("Expires: 0");
    		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    		header("Cache-Control: private", false);
        $objWriter = \PHPExcel_IOFactory::createWriter($this, $extension == '.xlsx' ?  'Excel2007' : 'Excel5');
        $objWriter->save('php://output');
        die();
    }

    /**
     * Envia el archivo al browser para descargarse
     * @param string $filename
     */
    public function saveTo($directory = '/tmp/reportes-sidi', $basename = 'report', $extension = '.xlsx')
    {
        if( !is_dir($directory) ){
            @mkdir($directory, 0777, true);
        }

        $filename = $directory . '/' . $basename . $extension;
        if( file_exists($filename) ){
            @unlink($filename);
        }

        $this->setActiveSheetIndex(0);

        $objWriter = \PHPExcel_IOFactory::createWriter($this, $extension == '.xlsx' ?  'Excel2007' : 'Excel5');
        $objWriter->save($filename);

        return $filename;
    }

    /**
     * inicializa los estilos
     */
    protected function initStyles()
    {
        $this->getDefaultStyle()->getFont()->applyFromArray($this->defaultFont);

        $defaultBorder = array(
           'style' => \PHPExcel_Style_Border::BORDER_THIN,
           'color' => array('argb' => 'FFCCCCCC'),
        );
        $defaultBorders = array(
            'bottom'    => $defaultBorder,
            'top'       => $defaultBorder,
            'left'      => $defaultBorder,
            'right'     => $defaultBorder,
        );
        $styleBody = new \PHPExcel_Style();
        $styleBody->applyFromArray(array(
          'font'   => array(
                                'name'      => 'Arial',
                                'size'      => 10,
                       ),
          'fill'   => array(
                                'type'      => \PHPExcel_Style_Fill::FILL_SOLID,
                                'color'     => array('argb' => 'FFEFEFEF')
                           ),
          'borders' => $defaultBorders,
          'alignment' => array(
                                'wrap' => true,
                                'horizontal' => 'center',
                              ),
        ));
        $this->styleBody = $styleBody;

        $styleBodyOdd = new \PHPExcel_Style();
        $styleBodyOdd->applyFromArray(array(
          'font'   => array(
                                'name'      => 'Arial',
                                'size'      => 10,
                       ),
          'fill'   => array(
                                'type'      => \PHPExcel_Style_Fill::FILL_SOLID,
                                'color'     => array('argb' => 'FFF2F2F2')
                           ),
          'borders' => $defaultBorders,
          'alignment' => array(
                                'wrap' => true,
                                'horizontal' => 'center',
                              ),
        ));
        $this->styleBodyOdd = $styleBodyOdd;

        $styleHeader = new \PHPExcel_Style();
        $styleHeader->applyFromArray(array(
           'font'   => array(
                                'name'      => 'Arial',
                                'size'      => 12,
                                'bold'      => true,
                       ),
           'fill'   => array(
                                'type'      => \PHPExcel_Style_Fill::FILL_SOLID,
                                'color'     => array('argb' => 'FFE46C0A')
                            ),
           'borders'=> $defaultBorders,
           'alignment' => array(
                                'wrap' => true,
                                'horizontal' => 'center',
                              ),
         ));
         $styleHeader->getFont()->setBold(true)->getColor()->setARGB('FFFFFFFF');
         $this->styleHeader = $styleHeader;

         $styleSubHeader = new \PHPExcel_Style();
         $styleSubHeader->applyFromArray(array(
           'font'   =>  array(
                                'bold'      => true,
                                'name'      => 'Arial',
                                 'size'        => 9,
                             ),
           'fill'   => array(
                                'type'      => \PHPExcel_Style_Fill::FILL_SOLID,
                                'color'     => array('argb' => 'FFFDEADA')
                            ),
           'borders' => $defaultBorders,
           'alignment' => array(
                                'wrap' => true,
                                'horizontal' => 'center',
                              ),
         ));
         $styleSubHeader->getFont()->setBold(true);
         $this->styleSubheader = $styleSubHeader;

         $styleFooter = new \PHPExcel_Style();
         $styleFooter->applyFromArray(array(
           'font'   => array_merge( array(
                                'bold'      => true,
                            ), $this->defaultFont),
           'fill'   => array(
                                'type'      => \PHPExcel_Style_Fill::FILL_SOLID,
                                'color'     => array('argb' => 'FFFDEADA')
                            ),
           'borders'=> $defaultBorders,
           'alignment' => array(
                                'wrap' => true,
                                'horizontal' => 'center',
                              ),
         ));
         $styleFooter->getFont()->setBold(true);
         $this->styleFooter = $styleFooter;
    }


    /**
     * Traductor
     * @param Zend_Translate $l10n
     */
    public function setL10n($l10n)
    {
        $this->l10n = $l10n;
    }

    /**
     *
     * @param string $from
     * @param string $to
     * @param int $row
     */
    public function applyHeaderStyle($from, $to, $row =null)
    {
        if(null == $row) $row = $this->getDefaultRowHeader();
        $this->getActiveSheet()->setSharedStyle($this->getStyleHeader(), $from.$row.':'.$to.$row);
    }

    /**
     *
     * @param string $from
     * @param string $to
     * @param int $row
     */
    public function applySubHeaderStyle($from, $to, $row)
    {
        $this->getActiveSheet()->setSharedStyle($this->getStyleSubheader(), $from.$row.':'.$to.$row);
    }

    /**
     *
     * @param string $from
     * @param string $to
     * @param int $row
     */
    public function applyFooterStyle($from, $to, $row)
    {
        $this->getActiveSheet()->setSharedStyle($this->getStyleFooter(), $from.$row.':'.$to.$row);
    }

    /**
     *
     * @param unknown_type $from
     * @param unknown_type $to
     * @param unknown_type $r2
     * @param unknown_type $r1
     */
    public function applyBodyStyle($from, $to, $r2, $r1 =null)
    {
        if(null == $r1) $r1 = $this->getDefaultRow();
        $this->getActiveSheet()->setSharedStyle($this->getStyleBody(), $from.$r1.':'.$to.$r2);
    }

    /**
     *
     * @param unknown_type $from
     * @param unknown_type $to
     * @param unknown_type $r2
     * @param unknown_type $r1
     */
    public function applyBodyOddStyle($from, $to, $r2, $r1)
    {
        for( $i = $r1; $i <= $r2 ; $i++ ){
            if( $i % 2 == 0 ){
                $this->getActiveSheet()->setSharedStyle($this->getStyleBodyOdd(), $from.$i.':'.$to.$i);
            }
        }

    }

    /**
     * @return the $defaultRow
     */
    public function getDefaultRow() {
        return $this->defaultRow;
    }

    /**
     * @return the $defaultRowHeader
     */
    public function getDefaultRowHeader() {
        return $this->defaultRowHeader;
    }

    /**
     * @param $defaultRow the $defaultRow to set
     */
    public function setDefaultRow($defaultRow) {
        $this->defaultRow = $defaultRow;
    }

    /**
     * @param $defaultRowHeader the $defaultRowHeader to set
     */
    public function setDefaultRowHeader($defaultRowHeader) {
        $this->defaultRowHeader = $defaultRowHeader;
    }

    /**
     * @return the $styleBody
     */
    public function getStyleBody() {
        return $this->styleBody;
    }

    /**
     * @param $styleBody the $styleBody to set
     */
    public function setStyleBody($styleBody) {
        $this->styleBody = $styleBody;
    }

    /**
     * @return the $styleHeader
     */
    public function getStyleHeader() {
        return $this->styleHeader;
    }

    /**
     * @param $styleHeader the $styleHeader to set
     */
    public function setStyleHeader($styleHeader) {
        $this->styleHeader = $styleHeader;
    }

    /**
     * @return the $styleSubheader
     */
    public function getStyleSubheader() {
        return $this->styleSubheader;
    }

    /**
     * @param $styleSubheader the $styleSubheader to set
     */
    public function setStyleSubheader($styleSubheader) {
        $this->styleSubheader = $styleSubheader;
    }

    /**
     * @return the $styleFooter
     */
    public function getStyleFooter() {
        return $this->styleFooter;
    }

    /**
     * @param \PHPExcel_Style $styleFooter
     */
    public function setStyleFooter($styleFooter) {
        $this->styleFooter = $styleFooter;
    }

    /**
     * @return the $styleBodyOdd
     */
    public function getStyleBodyOdd() {
        return $this->styleBodyOdd;
    }

    /**
     * @param \PHPExcel_Style $styleBodyOdd
     */
    public function setStyleBodyOdd($styleBodyOdd) {
        $this->styleBodyOdd = $styleBodyOdd;
    }

}
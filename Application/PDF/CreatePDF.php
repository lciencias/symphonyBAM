<?php

namespace Application\PDF;

use dompdf;

//require_once 'dompdf/dompdf_config.inc.php';
//include 'dompdf/dompdf.php';

class CreatePDF extends DOMPDF {
    private $_html;
    protected $_pdf;
    
    public function setHtml($html){
        $this->_html = $html;
        return $this;
    }
    
    public function getHtml() {
        return $this->_html;
    }
    
    public function setPdf($obj){
        $this->_pdf = $obj;
        return $this;
    }
    
    public function getPdf(){
        return $this->_pdf;
    }
    
    public function __construct() {
        return new DOMPDF();
        /*$pdf = parent::__construct();
        
        if (empty($html)) {
            throw new \Exception('Need string in the html');
        }
        
        $this->setHtml($html);
        
        $pdf->set_paper("letter", "landscape");
        $pdf->load_html($this->getHtml());
        $pdf->render();
        
        return $this->setPdf($pdf);*/
    }
}
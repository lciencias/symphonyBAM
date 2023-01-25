<?php 

/**
 *
 * Manager 
 * @author 
 **/
namespace Application\Manager;

class FixManager {
    
    
    
    public function utf8_encode_array($data){
        $dataConvert=array_map("self::utf8_encode_array_lib", $data); 
        return $dataConvert;
    }
    
    
    private function utf8_encode_array_lib($array) {
        if(is_array($array)){
            foreach($array as $key => $value)
           {
                
               if(is_array($value))
                   $array[$key] = self::utf8_encode_array_lib($value);
               else
                   $array[$key] = utf8_encode($value);
            }
        }else
            $array = utf8_encode($array);
        
       return $array;
    }   



    public function cleanCaracteres($String) {
    $String=  strtolower(trim($String));
    $String = str_replace(array('á','à','â','ã','ª','ä'),"a",$String);
    $String = str_replace(array('Á','À','Â','Ã','Ä'),"a",$String);
    $String = str_replace(array('Í','Ì','Î','Ï'),"i",$String);
    $String = str_replace(array('í','ì','î','ï'),"i",$String);
    $String = str_replace(array('é','è','ê','ë'),"e",$String);
    $String = str_replace(array('É','È','Ê','Ë'),"e",$String);
    $String = str_replace(array('ó','ò','ô','õ','ö','º'),"o",$String);
    $String = str_replace(array('Ó','Ò','Ô','Õ','Ö'),"o",$String);
    $String = str_replace(array('ú','ù','û','ü'),"u",$String);
    $String = str_replace(array('Ú','Ù','Û','Ü'),"u",$String);
    $String = str_replace(array('Ú','Ù','Û','Ü'),"u",$String);
    $String = str_replace(array('ñ', 'Ñ'),"n",$String);
    $String = str_replace(" ","_",$String);   
    
    return $String;
    }

    public function getArrayTrimester(){
        
        $fecha = date('m');
        $trimestre= self::getQuarterByMonth($fecha);
        $mesIni=27;
        $anioR=date("Y");
        switch($trimestre){
            case '1':
                $fechaIni=$anioR."-01-01";
                break;
            case '2':
                $fechaIni=$anioR."-04-01";
                break;
            case '3':
                $fechaIni=$anioR."-07-01";
                break;
            case '4':
                $fechaIni=$anioR."-10-01";
                break;
        }
        $nuevafecha = strtotime ( '-'.$mesIni.' month' , strtotime ( $fechaIni ) ) ;
        $nuevafecha = date ( 'Y-m-d' , $nuevafecha );
        $fechaActual=explode("-",$fechaIni);
        $arrayDate=explode("-",$nuevafecha);
        
        $arrayCombo=array();        
        $anio=(int)$arrayDate[0];//2014
        $mes=(int) $arrayDate[1]; // 07
        for($i=$anio;$i<=date('Y');$i++){
            for($n=$mes;$n<=12;$n= $n+3){
                if($i==date('Y') && $n>$fechaActual[1])
                    continue;
                $trimNumber=$this->getQuarterByMonth($n);
                $key=$i."-".str_pad($n,2, '0', STR_PAD_LEFT)."-01";
                $arrayCombo[$key]=$this->getNameNumber($trimNumber)." Trimestre ".$i;                
            }
            $mes=1;
        }
       
        return $arrayCombo;
    }
    
    
    public static function getQuarterByMonth($monthNumber) {
     return floor(($monthNumber - 1) / 3) + 1;
    }

public function getNameNumber($number){
    switch($number){
        case '1':
            $name=" 1er ";
            break;
        case '2';
            $name=" 2do ";
            break;
        case '3':
            $name=" 3er ";
            break;
        case '4':
            $name=" 4to ";
            break;
    }
    return $name;
    
}

	
}
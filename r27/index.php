<?php
require("class/db.php");
require("class/functions.php");
//Debug($_POST);
$fecini = date("Ymd", strtotime($_POST["start_date"]));
$fecfin = date("Ymd", strtotime($_POST["end_date"]));
//echo "$fecini-$fecfin";
//exit;

$cuenta="00000587028";

mysql_query("SET @row:=0");
$meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio', 'Agosto','Septiembre','Octubre','Noviembre','Diciembre');

$select = "SELECT id_ticket_client, MONTH(b.created) as Periodo, '128' as ClaveEntidad,'2701'as ClaveFormulario,@row:=@row+1 AS NumeroSecuencia,t.folio,DATE_FORMAT(b.created, '%Y%m%d')FechaReclamacion,DATE_FORMAT(b.created, '%Y%m%d')FechaSuceso,t.account_number,b.status,t.id_client_category,t.id_base_ticket
FROM pcs_symphony_tickets_clients t
INNER JOIN pcs_symphony_base_tickets b
ON t.id_base_ticket = b.id_base_ticket
WHERE DATE_FORMAT(created, '%Y%m%d') >= '$fecini' AND DATE_FORMAT(created, '%Y%m%d') <= '$fecfin'
ORDER BY id_ticket_client desc";

/*$select["datos"] = "SELECT id_ticket_client, MAX(FechaOperacion) FechaOperacion, MAX(HoraOperacion) HoraOperacion, MAX(Ubicacion) Ubicacion, MAX(Adquiriente)Adquiriente, MAX(Monto)Monto
FROM (
  SELECT
	id_ticket_client,
    CASE WHEN id_field = 2 THEN value END AS 'FechaOperacion',
    CASE WHEN id_field = 3 THEN value END AS 'HoraOperacion',
    CASE WHEN id_field = 7 THEN value END AS 'Ubicacion',
    CASE WHEN id_field = 8 THEN value END AS 'Adquiriente',
    CASE WHEN id_field = 10 THEN value END AS 'Monto'
  FROM pcs_symphony_ticket_client_fields
   where id_ticket_client = 1263 
)d 
GROUP BY id_ticket_client
ORDER BY id_ticket_client";

$select["asigna"] = "SELECT * FROM pcs_symphony_assignments where id_base_ticket = 1316";
*/
//echo $select;

$rs = mysql_query($select);
while($row=mysql_fetch_assoc($rs)){
	$reporte[] = $row;	
}
/*$rs = $dbh->prepare($select);
$rs->execute();	
$reporte = $rs->fetchAll();*/
$File = "reportes/R27".date("Ymd").".txt";
$Handle = fopen($File, 'w');
		$space = "\r\n";							
		$texto = "folio;FechaReclamacion;FechaSuceso;account_number;Producto;Canal;Motivo;Importe Reclamado;Estado;Resolucion;Fecha Resolucion;Causa Resolucion;Importe Abonado;Fecha Abono;Importe Recuperado;Quebranto;Origen";
		fwrite($Handle, utf8_decode($texto).$space); 
foreach ($reporte as $key => $value) {
	if($key == 0){
		//echo "<table border='1'><tr><td>Periodo</td><td>ClaveEntidad</td><td>ClaveFormulario</td><td>NumeroSecuencia</td><td>folio</td><td>FechaReclamacion</td><td>FechaSuceso</td><td>account_number</td><td>Producto</td><td>Canal</td><td>Motivo</td><td>Importe Reclamado</td><td>Estado</td><td>Resolucion</td><td>Fecha Resolucion</td><td>Causa Resolucion</td><td>Importe Abonado</td><td>Fecha Abono</td><td>Importe Recuperado</td><td>Quebranto</td><td>Origen</td></tr>";
	}
	$datos = "SELECT id_ticket_client, MAX(FechaOperacion) FechaOperacion, MAX(HoraOperacion) HoraOperacion, MAX(Ubicacion) Ubicacion, MAX(Adquiriente)Adquiriente, MAX(MontoSolicitado)MontoSolicitado, MAX(MontoRecibido)MontoRecibido, MAX(MontoReclamado)MontoReclamado
				FROM (
				  SELECT
					id_ticket_client,
				    CASE WHEN id_field = 2 THEN value END AS 'FechaOperacion',
				    CASE WHEN id_field = 3 THEN value END AS 'HoraOperacion',
				    CASE WHEN id_field = 7 THEN value END AS 'Ubicacion',
				    CASE WHEN id_field = 8 THEN value END AS 'Adquiriente',
				    CASE WHEN id_field = 10 THEN value END AS 'MontoSolicitado',
                    CASE WHEN id_field = 11 THEN value END AS 'MontoRecibido',
                    CASE WHEN id_field = 28 THEN value END AS 'MontoReclamado'
				  FROM pcs_symphony_ticket_client_fields
				   where id_ticket_client = ".$value["id_ticket_client"]."
				)d 
				GROUP BY id_ticket_client
				ORDER BY id_ticket_client";
	/*$rs = $dbh->prepare($datos);
	$rs->execute();	
	$res = $rs->fetch();*/
	$rs = mysql_query($datos);
	$res = mysql_fetch_assoc($rs);

	//if(trim($res["MontoSolicitado"])!=""){
		$tarjeta=GetTarjeta($value["account_number"]);
		$producto=GetProducto($value["account_number"]);
		$razones = array(9 => 601,10 =>605,11 => 651,3 => 602,12 => 652,4 => 603,13 => 653,8 => 604);
		$productos = array(1003 => 103,1006 =>103,1004 =>103,1011 =>103,1013 =>103);
		$motivo = array(45 => 301,51 => 310,52 => 310,53 => 301,64 => 318,83 => 312,105 => 390,151 => 312,247 => 390,249 => 390,250 => 390);
		/*Debug($tarjeta);
		exit;*/
		//$tipo=2;
		//echo "<tr><td>".$meses[$value["Periodo"]-1]."</td><td>".$value["ClaveEntidad"]."</td><td>".$value["ClaveFormulario"]."</td><td>".$value["NumeroSecuencia"]."</td><td>".$value["folio"]."</td><td>".$value["FechaReclamacion"]."</td><td>".(date("Ymd",strtotime($res["FechaOperacion"])) == "19691231" ? "" : date("Ymd",strtotime($res["FechaOperacion"])) )."</td><td>".($tipo == 1 ? $tarjeta[0][0] : $tarjeta[0][2] )."</td><td>".$producto[0][2]."</td><td>".GetCanal($value["id_client_category"])."</td><td>".$value["id_client_category"]."</td><td>".$res["MontoSolicitado"]."</td><td>".($value["status"] == 5 ? 402: 401)."</td><td>".(GetResolution($value["id_base_ticket"]) == "" ? 503 : (GetResolution($value["id_base_ticket"]) == 1 ? 501 : 502 ))."</td><td>".(date("Ymd",strtotime(GetDateResolution($value["id_base_ticket"]))) == "19691231" ? "" : date("Ymd",strtotime(GetDateResolution($value["id_base_ticket"]))) )."</td><td>".(GetCausa($value["id_base_ticket"]) == "" ? 654 : $razones[GetCausa($value["id_base_ticket"])])."</td><td>".(GetResolution($value["id_base_ticket"]) == 2 ? 0 : $res["MontoSolicitado"])."</td><td>".(date("Ymd",strtotime(GetDateResolution($value["id_base_ticket"]))) == "19691231" ? "" : date("Ymd",strtotime(GetDateResolution($value["id_base_ticket"]))) )."</td><td>".(GetResolution($value["id_base_ticket"]) == 1 ? 0 : $res["MontoSolicitado"])."</td><td>".(GetResolution($value["id_base_ticket"]) == 1 ? $res["MontoSolicitado"] : 0 )."</td><td>701</td></tr>";
		//$texto = $meses[$value["Periodo"]-1].",".$value["ClaveEntidad"].",".$value["ClaveFormulario"].",".$value["NumeroSecuencia"].",".$value["folio"].",".$value["FechaReclamacion"].",".(date("Ymd",strtotime($res["FechaOperacion"])) == "19691231" ? "" : date("Ymd",strtotime($res["FechaOperacion"])) ).",".(!in_array($producto[0][2], $productos) ? (strrpos($tarjeta[0][0], "No records were found") === false ? $tarjeta[0][0] : $value["account_number"]) : $tarjeta[0][2] ).",".$productos[$producto[0][2]].",".(strrpos(GetCanal($value["id_client_category"]), "ATM ") === false ? 290 : 206 ).",".$motivo[$value["id_client_category"]].",".$res["MontoSolicitado"].",".($value["status"] == 5 ? 402: 401).",".(GetResolution($value["id_base_ticket"]) == "" ? 503 : (GetResolution($value["id_base_ticket"]) == 1 ? 501 : 502 )).",".(date("Ymd",strtotime(GetDateResolution($value["id_base_ticket"]))) == "19691231" ? "" : date("Ymd",strtotime(GetDateResolution($value["id_base_ticket"]))) ).",".(GetCausa($value["id_base_ticket"]) == "" ? 654 : $razones[GetCausa($value["id_base_ticket"])]).",".(GetResolution($value["id_base_ticket"]) == 2 ? 0 : $res["MontoSolicitado"]).",".(date("Ymd",strtotime(GetDateResolution($value["id_base_ticket"]))) == "19691231" ? "" : date("Ymd",strtotime(GetDateResolution($value["id_base_ticket"]))) ).",".(GetResolution($value["id_base_ticket"]) == 1 ? 0 : $res["MontoSolicitado"]).",".(GetResolution($value["id_base_ticket"]) == 1 ? $res["MontoSolicitado"] : 0 ).",701";
		//echo $value["FechaReclamacion"]."-".date("Y/m/d",strtotime($value["FechaReclamacion"])) ."##".(date("Ymd",strtotime($value["FechaReclamacion"])) == "19691231" ? "" : date("Y/m/d",strtotime($value["FechaReclamacion"])) )."<br>".$res["FechaOperacion"]."-".(date("Ymd",strtotime($res["FechaOperacion"])) == "19691231" ? "" : date("Y/m/d",strtotime($res["FechaOperacion"])) );
		$texto = $value["folio"].";".(date("Ymd",strtotime($value["FechaReclamacion"])) == "19691231" ? "" :date("Y/m/d",strtotime($value["FechaReclamacion"])) ).";".(date("Ymd",strtotime($res["FechaOperacion"])) == "19691231" ? "" : date("Y/m/d",strtotime($res["FechaOperacion"])) ).";".(!in_array($producto[0][2], $productos) ? (strrpos($tarjeta[0][0], "No records were found") === false ? $tarjeta[0][0] : $value["account_number"]) : $tarjeta[0][2] ).";".$productos[$producto[0][2]].";".(strrpos(GetCanal($value["id_client_category"]), "ATM ") === false ? 290 : 206 ).";".$motivo[$value["id_client_category"]].";".$res["MontoSolicitado"].";".($value["status"] == 5 ? 402: 401).";".(GetResolution($value["id_base_ticket"]) == "" ? 503 : (GetResolution($value["id_base_ticket"]) == 1 ? 501 : 502 )).";".(date("Ymd",strtotime(GetDateResolution($value["id_base_ticket"]))) == "19691231" ? "" : date("Y/m/d",strtotime(GetDateResolution($value["id_base_ticket"]))) ).";".(GetCausa($value["id_base_ticket"]) == "" ? 654 : $razones[GetCausa($value["id_base_ticket"])]).";".(GetResolution($value["id_base_ticket"]) == 2 ? 0 : $res["MontoSolicitado"]).";".(date("Ymd",strtotime(GetDateResolution($value["id_base_ticket"]))) == "19691231" ? "" : date("Y/m/d",strtotime(GetDateResolution($value["id_base_ticket"]))) ).";".(GetResolution($value["id_base_ticket"]) == 1 ? 0 : $res["MontoSolicitado"]).";".(GetResolution($value["id_base_ticket"]) == 1 ? $res["MontoSolicitado"] : 0 ).";701";
		fwrite($Handle, $texto.$space); 
		//Debug($tarjeta);exit;
	//}		
}
fclose($Handle);
//echo "</table>";


header("Pragma: public"); // required 
header("Expires: 0"); 
header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
header("Cache-Control: private",false); // required for certain browsers  
header("Content-Type: $ctype"); 
// change, added quotes to allow spaces in filenames, by Rajkumar Singh 
header("Content-Disposition: attachment; filename=\"".basename($File)."\";" ); 
header("Content-Transfer-Encoding: binary"); 
header("Content-Length: ".filesize($File)); 
readfile("$File"); 
exit(); 

//Debug($reporte);
?>
<?
function Debug($var){
	echo "<hr><pre>";
	//var_dump($var);
	print_r($var);
	echo "</pre><hr>";
}


function GetTarjeta($cuenta){
	$enq="ENQUIRY.SELECT,,OFSBAMBE/Ab123456,BAM.CUENTA.TARJETA,NO.TARJETA:EQ:=$cuenta";
	//echo $enq;
	$enqlen= str_pad(strlen($enq),4,"0",STR_PAD_LEFT);
	$enq = $enqlen.$enq;
	$sock = stream_socket_client("10.15.1.32:7003", $errno, $errstr); 
	fwrite($sock,$enq);
	$packed_len = stream_get_contents($sock, 4);
	$res = fgets($sock,$packed_len);
	fclose($sock);  
	$resultado = explode('","', $res);	
	foreach ($resultado as $key => $value) {
		$cons[$key] = explode('"', $value);
		foreach ($cons[$key] as $k => $v) {
			if($k == 0){
				$encabezados = explode('/', $v);
			}
			$cons[$key][$k] = trim($v);
		}
	}
	$i = 0;
	unset($cons[0][0]);
	$cons[0] = array_values($cons[0]);
	return $cons;
		
}

function GetProducto($cuenta){
	$enq="ENQUIRY.SELECT,,OFSBAMBE/Ab123456,BAM.CUENTA.PRODUCTO,ACCOUNT.NO:EQ:=$cuenta";
	//echo $enq;
	$enqlen= str_pad(strlen($enq),4,"0",STR_PAD_LEFT);
	$enq = $enqlen.$enq;
	$sock = stream_socket_client("10.15.1.32:7003", $errno, $errstr); 
	fwrite($sock,$enq);
	$packed_len = stream_get_contents($sock, 4);
	$res = fgets($sock,$packed_len);
	fclose($sock);  
	$resultado = explode('","', $res);	
	foreach ($resultado as $key => $value) {
		$cons[$key] = explode('"', $value);
		foreach ($cons[$key] as $k => $v) {
			if($k == 0){
				$encabezados = explode('/', $v);
			}
			$cons[$key][$k] = trim($v);
		}
	}
	$i = 0;
	unset($cons[0][0]);
	$cons[0] = array_values($cons[0]);
	return $cons;
		
}

function GetCanal($id){
	$select = "SELECT name FROM pcs_symphony_client_categories WHERE id_client_category = $id";
	$rs = mysql_fetch_row(mysql_query($select));
	
	return $rs[0];
		
}

function GetResolution($id){
	$select = "SELECT id_resolution FROM pcs_symphony_assignments WHERE id_base_ticket = $id";
	//echo $select."<br>";
	$rs = mysql_fetch_row(mysql_query($select));
	//Debug($rs);
	if($rs[0]){
		$rs0 = mysql_fetch_row(mysql_query("SELECT type FROM pcs_symphony_client_resolutions WHERE id_client_resolution = ".$rs[0]));	
	}
	return $rs0[0];
		
}

function GetCausa($id){
	$select = "SELECT id_resolution FROM pcs_symphony_assignments WHERE id_base_ticket = $id";
	//echo $select."<br>";
	$rs = mysql_fetch_row(mysql_query($select));
	//$rs0 = mysql_fetch_row(mysql_query("SELECT name FROM pcs_symphony_client_resolutions WHERE id_client_resolution = ".$rs[0]));	
	return $rs[0];
		
}

function GetDateResolution($id){
	$select = "SELECT resolution_date FROM pcs_symphony_assignments WHERE id_base_ticket = $id";
	//echo $select."<br>";
	$rs = mysql_fetch_row(mysql_query($select));	
	return $rs[0];
		
}
?>
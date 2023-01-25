<?php
/*try {
		//print_r(PDO::getAvailableDrivers());
		$hostname = "10.14.2.201";
		//$port = 1433;
		//$dbname = "gearcore";
		$dbname = "symphony_tickets";
		$dbuser = "root";
		$dbp = "My3q1s3rv3r";
		//$dsn = "sqlsrv;Server=$hostname;Database=$dbname;Uid=$dbuser;Pwd=$dbp;";
		$dsn = "mysql:host=$hostname;dbname=$dbname";
	    //$dsn = "odbc:Driver={FreeTDS};Server=10.20.1.17;Database=$dbname;Uid=$dbuser;Pwd=$dbpassword;";    
		$dbh = new PDO($dsn, $dbuser, $dbp);
	} catch (PDOException $e) {
		echo "Failed to get DB handle: " . $e->getMessage() . "\n";
		exit;
	}

	*/
		session_start();
	$dbhost =		"10.14.2.254"; 
	$dbname =		"symphony_tickets";
	$dbuser =		"root";
	$dbpassword =	"omael"; //MysqlPass2015 //
	
    $conexion = mysql_connect($dbhost, $dbuser, $dbpassword) or die( "Error de conexion al servidor" );
	mysql_select_db($dbname, $conexion) or die( "Error de conexion a la base de datos" );

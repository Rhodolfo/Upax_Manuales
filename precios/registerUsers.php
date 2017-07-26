<?php 

// Deps
require_once("pathConfig.php");
require_once("generatePassword.php");
require_once("$precios_path/php/config.php");
require_once("$precios_path/php/users.php");

// Read file
$file = "usuarios_pass.csv";
if (!$handle=file_get_contents($file)){
	die("No se ha mandado un archivo.\n");
}

// Fuck your carriage returns
$handle = preg_replace('/\r\n/',"\n",$handle);
$handle = preg_replace('/\r/',"\n",$handle);
$handle = explode("\n",$handle);

// Check if it is actually a csv
if (!$csv = array_map('str_getcsv',$handle)) {
	die("El archivo no es un csv.\n");
}

// Connect to database
$con = @new mysqli($db_host,$db_name,$db_pass,$db_data,$db_port);
if ($con->connect_error) {
	die("Ha fallado la conexión con la base de datos.\n");
}
$con->set_charset("utf8");

$length = count($csv) - 1;
foreach ($csv as $key=>$line) {
	if (count($line)!=6) {
		if ($key!=$length) {
			die("ERROR at $key $length\n");
		} else {
			die();
		}
	} else {
		$name = $line[0];
		$npat = $line[1];
		$nmat = $line[2];
		$mail = $line[3];
		$user = $line[4];
		$pass = $line[5];
		if (rho_populateUserTable($user,$pass,$name,$npat,$nmat,$mail,"usuarios",$con,0,1,0,1,0)) {
			echo "$user registered\n";
		} else {	
			echo "$user ERROR\n";
		}
	}
}

?>

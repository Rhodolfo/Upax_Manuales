<?php 

// Deps
require_once("pathConfig.php");
require_once("generatePassword.php");
require_once("$precios_path/php/config.php");

// Read file
$file = "usuarios.csv";
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

// Preparing some stuff
function checkMail($cox,$val) {
	$stmt = $cox->prepare("SELECT id from usuarios where email=?");
	$stmt->bind_param('s',$val);
	$stmt->bind_result($res);
	if (!$stmt->execute()) {die("$cox->error\n");}
	if (!$stmt->fetch()) {
		return false;
	} else {
		return $res;
	}
}
function checkUser($con,$val) {
	$stmt = $con->prepare("SELECT id from usuarios where usuario=?");
	$stmt->bind_param('s',$val);
	$stmt->bind_result($res);
	if (!$stmt->execute()) {die("$cox->error\n");}
	if (!$stmt->fetch()) {
		return false;
	} else {
		return $res;
	}
}


$length = count($csv) - 1;
foreach ($csv as $key=>$line) {
	if (count($line)!=4) {
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
		$user = preg_replace('/@.+?$/i',"",$mail);
		$pass = generatePassword(8);
		$check_mail = checkMail($con,$mail);
		$check_user = checkUser($con,$user);
		if ($check_mail) {
			echo "MAIL MATCHED at $check_mail $mail, mail already exists \n";
		} else {
			if ($check_user) {
				echo "USER MATCHED at $check_user $user, user name already exists \n";
			} else {
				echo "$name,$npat,$nmat,$mail,$user,$pass\n";	
			}
		}
	}
}

?>

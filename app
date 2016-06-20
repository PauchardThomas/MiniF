<?php

include('./ConstructionClass.php');
include('./ConstructionSqlHelper.php');
include('./ConstructionDAO.php');

menu();


function menu() {
	echo "\r\n";
	echo "\r\n";
	echo "\r\n";
	echo "\r\n";
	echo "		**********\r\n";
	echo "		** Menu **\r\n";
	echo "		**********\r\n";
	echo "\r\n";
	echo "\r\n";
	echo "\r\n";
	echo "1- Create SqlHelper Class \r\n";
	echo "2- Create  Class + DAO \r\n";
	echo "E- Escape \r\n";
	$choix = trim(fgets(STDIN));
	choix($choix);
}

function choix($choix) {
	if(intval($choix) == 1) {
		createSqlHelper();
	}elseif(intval($choix) == 2) {
		createclass();
	}elseif(ucfirst($choix) == "E"){
		exit();
	}else {
		menu();
	}
}

function createclass() {
	echo'Enter class name';
	echo "\n";
	$attributs = array();
	$reponse = trim(fgets(STDIN));

	 do {
		 echo'Enter an attribut ( E = Escape)	';
		 $attribute = trim(fgets(STDIN));
		 $attribute = str_replace(" ","",$attribute);
		 if(ucfirst($attribute) != "E") {array_push($attributs,strval($attribute));}
	 }while(ucfirst($attribute) != "E");



	$class = new ConstructClass();
	$dao = new ConstructDAO();
	$className = strval($reponse);
	
	$class->construction($className,$attributs);
	$dao->construction($className,$attributs);
	menu();
}

function createSqlHelper() {
	
	$array = array();
	
	$host_default ="localhost";
	echo "\r\n Host [".$host_default."] : ";
	$host = askParam($host_default);
	array_push($array,$host);
	
	$user_default = "root";
	echo "\r\n User [".$user_default."] : ";
	$user = askParam($user_default);
	array_push($array,$user);
	
	$password_default = "";
	echo "\r\n Password [".$password_default."]: ";
	$password = askParam($password_default);
	array_push($array,$password);
	
	echo "\r\n Database : ";
	$db = trim(fgets(STDIN));
	array_push($array,$db);
	
	$driver_default = "mysql";
	echo "\r\n Driver [".$driver_default."] : ";
	$driver = askParam($driver_default);
	array_push($array,$driver);
	
	$class = new ConstructSqlHelper();
	$class->construction($array);
}

function askParam($param) {
	$output ="";
	$val = trim(fgets(STDIN));
	$val == "" ? $output = $param : $output = $val;
	return $output;
}

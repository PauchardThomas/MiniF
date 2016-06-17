<?php

include('./ConstructionClass.php');
include('./ConstructionSqlHelper.php');

menu();

function menu() {
	echo "Menu \r\n";
	echo "1- Create SqlHelper Class \r\n";
	echo "2- Create  Class \r\n";
	echo "Q- Quitter \r\n";
	$choix = trim(fgets(STDIN));
	choix($choix);
}

function choix($choix) {
	if(intval($choix) == 1) {
		createSqlHelper();
	}elseif(intval($choix) == 2) {
		createclass();
	}elseif(ucfirst($choix) == "Q"){
		exit();
	}else {
		menu();
	}
}

function createclass() {
	echo'Saisir le nom de la classe';
	echo "\n";
	$attributs = array();
	$reponse = trim(fgets(STDIN));

	 do {
		 echo'Saisir un attribut ( q = quitter)';
		 $attribute = trim(fgets(STDIN));
		 if($attribute != "q") {array_push($attributs,strval($attribute));}
	 }while($attribute != "q");



	$class = new ConstructClass();

	$className = strval($reponse);

	$class->construction($className,$attributs);
}

function createSqlHelper() {
	
	$array = array();
	
	echo "\r\n Host : ";
	$host = trim(fgets(STDIN));
	array_push($array,$host);
	
	echo "\r\n User : ";
	$user = trim(fgets(STDIN));
	array_push($array,$user);
	
	echo "\r\n Password : ";
	$password = trim(fgets(STDIN));
	array_push($array,$password);
	
	echo "\r\n Database : ";
	$db = trim(fgets(STDIN));
	array_push($array,$db);
	
	echo "\r\n Driver : ";
	$driver = trim(fgets(STDIN));
	array_push($array,$driver);
	
	$class = new ConstructSqlHelper();
	$class->construction($array);
}

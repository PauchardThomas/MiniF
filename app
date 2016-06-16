<?php

include('./ConstructionClass.php');
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


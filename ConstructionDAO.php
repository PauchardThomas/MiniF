<?php

class ConstructDAO {
	
	private	$esc = "\n";
	private	$php = '<?php ';
	private $data =	"";
	
	/**
	*
	* Construction de la classe
	*
	**/
	function  construction($className,$attributs){

		$this->data .= $this->php;
		$this->data .= $this->esc;
		$this->data .= $this->esc;
		$this->data .= "include('./SqlHelper.php');";
		
		$this->data .= $this->esc . $this->esc . 'class '.ucfirst($className) . ' {';
		$this->data .= $this->esc;	
		$this->data .= $this->esc;
		
		$this->construct($className);
		$this->select($className);
		$this->data .= $this->esc;
		$this->insert($className,$attributs);
		$this->data .= $this->esc;
		$this->data .= '}';
		
		$this->createfile($className);
		
		
	}
	
	function construct($className) {
		$this->data .= "	function __construct() {
		new sql();
	}" . $this->esc;
	}
	function select($className) {
		
		$this->data .="
	function select() {
		\$stmt = sql::\$db->query('SELECT * FROM ".$className."');
		if (\$stmt->execute()) {
			while (\$row = \$stmt->fetch()) {
			print_r(\$row);
			}
		}
	}";
	}
	
	function insert($className,$attributs) {
		$this->data .= $this->esc;
		$this->data .= "	function insert(\$qcm) {".$this->esc." 		\$stmt = sql::\$db->prepare('INSERT INTO ".$className;
		$this->data .= $this->constructInsertRequest($className,$attributs);
	}
	
	function constructInsertRequest($className,$attributs) {
		$i = 1;
		$vals ="";
		$vals .= "(";
		
		foreach($attributs as $att) {
			$vals .= $att;
			if($i < count($attributs)) {$vals .= ',';}
			$i++;
		}
		
		unset($att);
		$i = 1;
		$vals .= " ) VALUES (";
		
		foreach($attributs as $att) {
			$vals .= ':'.$att;
			if($i < count($attributs)) {$vals .= ',';}
			$i++;
		}
		
		unset($att);
		$i = 1;
		$vals .= ")');";
		
		foreach($attributs as $att) {
			$vals .= $this->esc;
			$vals .= "		\$stmt->bindParam(':".$att."', \$".$className."->get".ucfirst($att)."());";
		}
		$vals .= $this->esc;
		$vals .= "		\$stmt->execute();".$this->esc."
		return sql::\$db->lastInsertId();
	}";
		
		return $vals;
	}
	
		/**
	*
	* Create file
	*
	**/
	function createfile($className) {
		file_exists('./DAO') == false ? mkdir('./DAO') : '';
		$monfichier = fopen('./DAO/'.ucfirst($className).'DAO.php', 'w+');
		fputs($monfichier,$this->data);
		fclose($monfichier);
	}
	
}
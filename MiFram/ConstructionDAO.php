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
		
		$this->data .= $this->esc . $this->esc . 'class '.ucfirst($className) . 'DAO {';
		$this->data .= $this->esc;	
		$this->data .= $this->esc;
		
		
		$this->construct($className);
		$this->select($className);
		$this->data .= $this->esc;
		
		$this->insert($className,$attributs);
		$this->data .= $this->esc;
		
		$this->update($className,$attributs);
		$this->data .= $this->esc;
		
		$this->deleteRequest($className,$attributs);
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
		$this->data .= "	function insert(\$".$className.") {".$this->esc." 		\$stmt = sql::\$db->prepare('INSERT INTO ".$className;
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
		
		$vals .= $this->constructParams($className,$attributs);
		$vals .= "		\$stmt->execute();".$this->esc."
		return sql::\$db->lastInsertId();
	}";
		return $vals;
	}
	
	function constructParams($className,$attributs) {
		$v ="";
		foreach($attributs as $att) {
			$v .= $this->esc;
			$v .= "		\$stmt->bindParam(':".$att."', \$".$className."->get".ucfirst($att)."());";
		}
		$v .= $this->esc;
	
		return $v;
	
	}
	
	function update($className,$attributs) {
		$this->data .= $this->esc;
		$this->data .= "	function update(\$".$className.") {".$this->esc." 		\$stmt = sql::\$db->prepare('UPDATE ".$className;
		$this->data .= $this->constructUpdateRequest($className,$attributs);
	}
	
	function constructUpdateRequest($className,$attributs) {
		$i = 1;
		$vals =" SET ";
		
		foreach($attributs as $att) {
			if($att != "id") {
				$vals .= '`' .$att . '` = :'.$att;
				if($i < count($attributs)) {$vals .= ',';}
				$i++;
			}
		}
		
		$vals .= " WHERE `id` = :id  ');";

		
		$vals .= $this->constructParams($className,$attributs);
		$vals .= $this->esc;
		$vals .= "		return \$stmt->rowCount() ? true : false;
	}";
		return $vals;
	}
	
	function deleteRequest($className,$attributs) {
		$this->data .= $this->esc;
		$this->data .= "	function delete(\$".$className.") {".$this->esc." 		\$stmt = sql::\$db->prepare('DELETE FROM ".$className . " WHERE `id` = :id')";
		$this->data .= $this->constructDeleteRequest($className,$attributs);
	}
	
	function constructDeleteRequest($className,$attributs) {
		$v ="";
		
		foreach($attributs as $att) {
			if($att == "id") {
				$v .= $this->esc;
				$v .= "		\$stmt->bindParam(':".$att."', \$".$className."->get".ucfirst($att)."());";
			}
		}
		$v .= $this->esc;
		$v .= "		\$stmt->bindParam(':id', \$".$className."->getId());";
		$v .= $this->esc;
		$v .= "		\$stmt->execute();";
		$v .= $this->esc;
		$v .= "		return \$stmt->rowCount() ? true : false;
	}";
		$v .= $this->esc;
		return $v;
	}
	
	/**
	*
	* Create file
	*
	**/
	function createfile($className) {
		file_exists('../DAO') == false ? mkdir('../DAO') : '';
		$monfichier = fopen('../DAO/'.ucfirst($className).'DAO.php', 'w+');
		fputs($monfichier,$this->data);
		fclose($monfichier);
	}
	
}
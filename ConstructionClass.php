<?php

class ConstructClass {
	
	private	$esc = "\n";
	private	$php = '<?php ';
	private $data =	"";


	
	/**
	*
	* Construction de la classe
	*
	**/
	function  construction($className,$attributs){

		$this->data .= $this->php . $this->esc . $this->esc . 'class '.$this->upperCase($className) . ' {';
		$this->data .= $this->esc;	
		
		$this->properties($attributs);
		
		$this->data .= $this->esc;
		$this->data .= '}';
		
		$this->createfile($className);
		
		
	}
	
	/**
	*
	* Construction des attributs
	*
	**/
	function properties($attributs) {
		
		foreach($attributs as $att) {
	
			$this->data .= $this->esc;
			$this->data .= "	##".$att ."##";
			
			$getter ="";
			$setter ="";
			$atributsdata ="";
			
			$atributsdata .= $this->esc .'	private $' . $att . ';';
			
			$getter .= $this->getter($att);
			
			$setter .= $this->setter($att);
			
		$this->data .= $atributsdata;
		$this->data .= $this->esc;
		$this->data .= $getter;
		$this->data .= $this->esc;
		$this->data .= $setter;
		$this->data .= $this->esc;
		}
	}
	
	/**
	*
	* Create file
	*
	**/
	function createfile($className) {
		file_exists('../Entity') == false ? mkdir('../Entity') : '';
		$monfichier = fopen('../Entity/'.$this->upperCase($className).'.php', 'w+');
		fputs($monfichier,$this->data);
		fclose($monfichier);
	}
	
	/**
	*
	* Create getter
	*
	**/
	function getter($att) {
		$a = $this->upperCase($att);
		return "	
	public function get".$a."()
	{
		return \$this->".$att.";
	}";
	}
	
	/**
	*
	* Create setter
	*
	**/
	function setter($att) {
		$a = $this->upperCase($att);
		return "	
	public function set".$a."($".$att.")
	{
		\$this->".$att." = $".$att.";
	}";
	}
	
	/**
	*
	*UpperCase first letter
	*
	**/
	function upperCase($a) {
		return ucfirst($a);
	}
	
	
	
	
	
	
}
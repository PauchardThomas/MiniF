<?php

class ConstructClass {
	
	private	$esc = "\n";
	private	$php = '<?php ';
	private $data =	"";


	
	
	function  construction($className,$attributs){
		
		$this->data .= $this->php . 'class '.$className . ' {';
		$this->data .= $this->esc;	
		
		$this->properties($attributs);
		
		$this->data .= $this->esc;
		$this->data .= '}';
		
		$this->createfile($className);
		
		
	}
	
	function properties($attributs) {
		foreach($attributs as $att) {
	
			$this->data .= $this->esc;
			$this->data .= "##".$att ."##";
			
			$getter ="";
			$setter ="";
			$atributsdata ="";
			
			$atributsdata .= '
			private $' . $att . ';';
			
			$getter .= "	
			public function get".$att."()
			{
			  return \$this->".$att.";
			}";
			
			$setter .= "	
			public function set".$att."($".$att.")
			{
			  \$this->".$att." = $".$att.";
			}";
			
		//****************//
		//** Construct **//	
		//**************//
		$this->data .= $atributsdata;
		$this->data .= $this->esc;
		$this->data .= $getter;
		$this->data .= $this->esc;
		$this->data .= $setter;
		$this->data .= $this->esc;
		}
	}
	
	function createfile($className) {
		$monfichier = fopen('./'.$className.'.php', 'w+');
		fputs($monfichier,$this->data);
		fclose($monfichier);
	}
	
	
	
	
	
}
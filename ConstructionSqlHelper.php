<?php

class ConstructSqlHelper {
	
	private	$esc = "\n";
	private	$php = '<?php ';
	private $data =	"";
	private $array = array('1'=>'$db_host','2'=>'$db_user','3'=>'$db_pass','4'=>'$db_db','5'=>'$db_type');
	private $array2 = array('1'=>'Host','2'=>'User','3'=>'Password','4'=>'DataBase','5'=>'Driver');
	
	private $i = 1;
	function construction($attributs) {
		
		$this->data .= $this->php . $this->esc . $this->esc . 'class Sql {';
		$this->data .= $this->esc;	
		
		$this->properties($attributs);
		$this->data .= $this->esc;	
		
		$this->datas();
		
		$this->data .= $this->esc;
		$this->data .= '}';
		
		$this->createfile();
	}
	
	
	function properties($attributs) {
		
		foreach($attributs as $att) {
	
			$this->data .= $this->esc;
			$this->data .= "##".$this->array2[$this->i] ."##";
			
			$atributsdata ="";
			
			$atributsdata .= $this->esc .'	private ' . $this->array[$this->i] . ' = "'.$att.'";';
			$this->i++;
			$this->data .= $atributsdata;
			$this->data .= $this->esc;
		}
	}
	
	/**
	*
	* Create file
	*
	**/
	function createfile() {
		file_exists('../DAO') == false ? mkdir('../DAO') : '';
		$monfichier = fopen('../DAO/SqlHelper.php', 'w+');
		fputs($monfichier,$this->data);
		fclose($monfichier);
	}
	
	function datas() {
		
		$this->data .= "    function __construct()
    {
		
        if (self::\$db === false) {
            \$this->connect();
        }
    }

    private function connect()
    {
		
        \$dsn = \$this->database_type . ':dbname=' . \$this->database_db . ';host=' . \$this->database_host;
        try {
            self::\$db = new PDO(\$dsn, \$this->database_user, \$this->database_pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
            self::\$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException \$e) {   
            echo 'Échec lors de la connexion : ' . \$e->getMessage();
        }
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
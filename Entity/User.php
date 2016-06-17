<?php 

class User {

##Username##
	private $Username;
	
	public function getUsername()
	{
		return $this->Username;
	}
	
	public function setUsername($Username)
	{
		$this->Username = $Username;
	}

##password##
	private $password;
	
	public function getPassword()
	{
		return $this->password;
	}
	
	public function setPassword($password)
	{
		$this->password = $password;
	}

##email##
	private $email;
	
	public function getEmail()
	{
		return $this->email;
	}
	
	public function setEmail($email)
	{
		$this->email = $email;
	}

##birthday##
	private $birthday;
	
	public function getBirthday()
	{
		return $this->birthday;
	}
	
	public function setBirthday($birthday)
	{
		$this->birthday = $birthday;
	}

}
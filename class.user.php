<?php

require_once('dbconfig.php');

class USER
{	

	private $conn;
	
	public function __construct()
	{
		$database = new Database();
		$db = $database->dbConnection();
		$this->conn = $db;
    }
	
	public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
	
	public function register($uname,$ucogn,$umail,$upass,$udata,$uluogo,$utel)
	{
		try
		{
			$new_password = password_hash($upass, PASSWORD_DEFAULT);
			
			$stmt = $this->conn->prepare("INSERT INTO Utente(Email,Nome,Cognome,password,Tipologia,Data_Nascita,Luogo_Nascita,Indirizzo_Residenza,Telefono) 
		                                               VALUES(:unmail, :uname, :ucogn, :upass, :udata, :uluogo, :utel)");
												  
			$stmt->bindparam(":umail", $umail);
			$stmt->bindparam(":uname", $uname);
			$stmt->bindparam(":ucogn", $ucogn);										  
			$stmt->bindparam(":upass", $new_password);
			$stmt->bindparam(":udata", $umail);
			$stmt->bindparam(":uluogo", $uluogo);	
			$stmt->bindparam(":utel", $utel);
			$stmt->execute();	
			
			return $stmt;	
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}				
	}
	
	
	public function doLogin($umail,$upass)
	{
		try
		{
			$stmt = $this->conn->prepare("SELECT * FROM Utente WHERE Email=:umail ");
			$stmt->bindparam(":umail", $umail);
			$stmt->execute();
			$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
			if($stmt->rowCount() > 0)
			{
				if(password_verify($upass, $userRow['Password']))
				{
					$_SESSION['user_session'] = $userRow['Email'];
					return true;
				}
				else
				{
					return false;
				}
			}
		}
		catch(PDOException $e)
		{
			echo $e->getMessage();
		}
	}
	
	public function is_loggedin()
	{
		if(isset($_SESSION['user_session']))
		{
			return true;
		}
	}
	
	public function redirect($url)
	{
		header("Location: $url");
	}
	
	public function doLogout()
	{
		session_destroy();
		unset($_SESSION['user_session']);
		return true;
	}
}
?>
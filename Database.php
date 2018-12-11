<?php
class Database {
	//This class will use PDO to access and process database requests


	//properties
	
	private	$databaseName="";
	private $userName="";
	private $password="";
	private $serverName="";
	
	private $conn="";		//Connection object
	private $stmt="";		//Statement object

	public function __construct($inDatabase,$inUser,$inPassword,$inServer) {
		$this->setDatabaseName($inDatabase);
		$this->setUserName($inUser);
		$this->setPassword($inPassword);
		$this->setServerName($inServer);
		
		$this->connectPDO();
	}
	
	private function setDatabaseName($inDatabaseName){
		$this->databaseName = $inDatabaseName;
	}

	private function setUserName($inUserName){
		$this->userName = $inUserName;
	}

	private function setPassword($inPassword){
		$this->password = $inPassword;
	}

	private function setServerName($inServerName){
		$this->serverName = $inServerName;
	}	
	
	//Get methods
	public function getDatabaseName() {
		return $this->databaseName;
	}

	public function getUserName() {
		return $this->userName;
	}	

	private function getPassword() {
		return $this->password;
	}	

	public function getServerName() {
		return $this->serverName;
	}

	//Processing Methods
	
	public function connectPDO() {
		
		$serverName = $this->serverName;
		$username = $this->userName;
		$password = $this->password;
		$database = $this->databaseName;

		try {
			$this->conn = new PDO("mysql:host=$serverName;dbname=$database", $username, $password);
			// set the PDO error mode to exception
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			echo "Connected successfully"; 
			}
		catch(PDOException $e)
			{
			//echo "Connection failed: " . $e->getMessage();
			
				$message = "There has been a problem. The system administrator has been contacted. Please try again later.";
	
				error_log($e->getMessage());			//Delivers a developer defined error message to the PHP log file at c:\xampp/php\logs\php_error_log
				error_log(var_dump(debug_backtrace()));
			
				//Clean up any variables or connections that have been left hanging by this error.		
			
				header('Location: files/505_error_response_page.php');	//sends control to a User friendly page						
				
			}		
	}//end connect()

	public function preparePDO($inSql) {
		
		try {

				$this->stmt = $this->conn->prepare($inSql);	
				//$this->stmt->execute();
				
				if($this->stmt) {
					echo "<p>PDO prepare failed</p>";	
					echo  $inSql;
					//throw new PDOException("The PDO prepare failed");					
				} else {
					echo "<p>PDO prepare successful</p>";
				}
			}
		catch(PDOException $e)
			{
				echo "Prepare failed: " . $e->getMessage();
			
				$message = "There has been a problem. The system administrator has been contacted. Please try again later.";
	
				error_log($e->getMessage());			//Delivers a developer defined error message to the PHP log file at c:\xampp/php\logs\php_error_log
				error_log(var_dump(debug_backtrace()));
			
				//Clean up any variables or connections that have been left hanging by this error.		
			
				header('Location: files/505_error_response_page.php');	//sends control to a User friendly page						
			}		
						
	}//end preparePDO()

	public function executePDO($arrayParams) {
		try {

		    //pass a this function an array of values
				$this->stmt->execute($arrayParams);	
				return $this->stmt->rowCount();					
			}
		catch(PDOException $e)
			{
				echo "Execute failed: " . $e->getMessage();
			
				$message = "There has been a problem. The system administrator has been contacted. Please try again later.";
	
				error_log($e->getMessage());			//Delivers a developer defined error message to the PHP log file at c:\xampp/php\logs\php_error_log
				error_log(var_dump(debug_backtrace()));
			
				//Clean up any variables or connections that have been left hanging by this error.		
			
				header('Location: files/505_error_response_page.php');	//sends control to a User friendly page						
			}				
	}//end executePDO()



	
}
?>
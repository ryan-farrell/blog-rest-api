<?php

include_once '../../include_config.php';

class Database {

	private $oConn;

	//DB Connect via PDO (PHP Database Objects)
	public function connect () {
		// $this->oConn = null;
	
		try { 
			$this->oConn = new PDO(
				'mysql:host=' . $_ENV['DBHOST'] . ';dbname=' . $_ENV['DBNAME'], $_ENV['DBUSERNAME'], $_ENV['DBPASSWORD']
			);
			$this->oConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		} catch (PDOException $e){
			echo 'Connection Error: ' . $e->getMessage();
		}

		return $this->oConn;
	}
}

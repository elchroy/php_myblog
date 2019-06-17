<?php

namespace Src\Config;

use PDO;
use PDOException;
/**
 */
class Database
{
	// DB Parameters
	private $hostname = 'localhost';
	private $port  = 3306;
	private $database = 'myblog';
	private $username = 'root';
	private $password = '';
	private $connection;
	
	public function connect()
	{
		$this->connection = null;

		try {
			$connectionString = "mysql:host={$this->hostname}:{$this->port};dbname={$this->database}";
			$this->connection = new PDO($connectionString, $this->username, $this->password);
			$this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		} catch (\PDOException $e) {
			echo "Connection Error: {$e->getMessage()}";
		}
		return $this->connection;
	}
}
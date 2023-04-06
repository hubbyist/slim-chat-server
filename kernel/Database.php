<?php
#--
# ---------------------------------------------------------------------------- *
#
# LICENSE UNDECIDED
#
# ---------------------------------------------------------------------------- *
# Copyright 2023 Mehmet Durgel. All Rights Reserved.
# ---------------------------------------------------------------------------- *
# @author Mehmet Durgel<md@legrud.net>
# ---------------------------------------------------------------------------- *
#--

namespace SlimChatServer;

use PDO;

class Database {

	private const DSN = 'sqlite:%s';

	private $connection = null;
	private $dsn = null;

	public function __construct(string $path){
		$filepath = dirname(__DIR__) . '/' . preg_replace(['#[.][.]/#', '#[.]/#', '#/{2,}#'], ['', '', '/'], $path) . '.db';
		if(!file_exists($filepath))
		{
			throw new \Exception('Database Path Unusable!');
		}
		$this->dsn = sprintf(self::DSN, $filepath);
	}

	public function connect(){
		$this->connection = new PDO($this->dsn);
		$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $this->connection;
	}

	public function query(string $query, ?array $parameters = []){
		$statement = $this->connection->prepare($query);
		foreach($parameters as $no => $value){
			$statement->bindParam($no, $value);
		}
		$result = $statement->execute();
		return $statement->fetchAll(PDO::FETCH_OBJ);
	}
}

?>

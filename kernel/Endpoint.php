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

use SlimChatServer\Settings;
use SlimChatServer\Database;

class Endpoint {

	protected $database = null;
	protected $table = null;
	protected $resource = null;

	public function __construct(){
		$this->database = new Database(Settings::call()->database);
		$this->resource = $this->database->connect();
	}

	public function all(){
		$query = sprintf("SELECT * FROM %s;", $this->table);
		return $this->query($query);
	}

	public function one(int $id){
		$query = sprintf("SELECT * FROM %s WHERE id = ?;", $this->table);
		$parameters = [1 => $id];
		return $this->query($query, $parameters);
	}

	public function some(array $filters){
		$parameters = [];
		$wheres = [];
		if(is_array($filters))
		{
			foreach($filters as $field => $value){
				$no = count($wheres) + 1;
				$wheres[$no] = "$field = ?";
				$parameters[$no] = $value;
			}
		}
		$query = sprintf("SELECT * FROM %s WHERE " . implode(', ', $wheres) . ";", $this->table);
		return $this->query($query, $parameters);
	}

	public function add(array $inputs){
		$fields = implode(', ', array_keys($inputs));
		$placeholders = trim(str_repeat('? ,', count($inputs)), ' ,');
		$query = sprintf("INSERT INTO %s ($fields) VALUES ($placeholders);", $this->table);
		$parameters[0] = null;
		$parameters = array_merge(array_values($inputs));
		unset($parameters[0]);
		return $this->query($query, $parameters);
	}

	protected function query(string $query, ?array $parameters = []){
		$result = $this->database->query($query, $parameters);
		if(!is_array($result))
		{
			throw new \Exception('Query Error');
		}
		return $result;
	}
}

?>

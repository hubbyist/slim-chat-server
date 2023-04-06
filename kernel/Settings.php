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

class Settings {

	private static $instance;
	protected $settings = [];

	protected function __construct(){
		return;
	}

	protected function __clone(){
		return;
	}

	public function __wakeup(){
		throw new \Exception("Singleton class is unserializable.");
	}

	public static function call(){
		if(true === is_null(self::$instance))
		{
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function init(array $settings = []){
		$this->settings = $settings;
	}

	public function __get(string $key){
		return $this->settings[$key] ?? null;
	}

	public function __set(string $key, mixed $value){
		$this->settings[$key] = $value;
		return $this->settings[$key];
	}
}

?>

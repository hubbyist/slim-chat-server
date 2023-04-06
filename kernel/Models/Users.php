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

namespace SlimChatServer\Models;

use SlimChatServer\Endpoint;
use SlimChatServer\Kernel;
use SlimChatServer\Settings;

class Users extends Endpoint {

	protected $table = 'users';

	public function login(string $username, string $password){
		$kernel = new Kernel();
		$user = $this->some(['username' => $username])[0] ?? null;
		if($user && $user->password == $kernel->hashText($password, $user->salt))
		{
			$cookie = Settings::call()->cookie;
			$token = $kernel->encodeJWT(['user' => ['id' => $user->id]]);
			$kernel->setCookie($cookie->name, $cookie->path, $token);
			return true;
		}
		return false;
	}
}

?>

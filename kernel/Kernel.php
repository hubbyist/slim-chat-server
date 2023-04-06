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

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use SlimChatServer\Settings;

class Kernel {

	const DEFAULT_HASH_ALGORITHM = 'gost';

	function respond(int $code, string $content, Response $response){
		$response->getBody()->write($content);
		$response->withStatus($code)
				->withHeader("Content-Type", "application/json");
		return $response;
	}

	function decodeJSON(Request $request){
		$body = $request->getBody();
		$json = json_decode($body, true);
		return $json;
	}

	function encodeJWT(array $claims){

		function encodeAsBase64Url($text){
			return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($text));
		}
		$header = encodeAsBase64Url(json_encode(['typ' => 'JWT', 'alg' => 'HS256']));
		$payload = encodeAsBase64Url(json_encode($claims));
		$secret = $signature = hash_hmac('sha256', $header . "." . $payload, Settings::call()->jwtsecret, true);
		$signature = encodeAsBase64Url($signature);
		$jwt = $header . "." . $payload . "." . $signature;
		return $jwt;
	}

	function decodeJWT(string $token){
		$payload = explode('.', $token)[1];
		return json_decode(base64_decode(str_replace(['_', '-'], ['/', '+'], $payload)));
	}

	function hashText(string $text, string $salt, string $algorithm = self::DEFAULT_HASH_ALGORITHM){
		return hash_hmac($algorithm, $text, $salt);
	}

	function setCookie(string $name, ?string $path, string $token){
		$cookie = [
			$name => $token,
			'path' => $path ?? '/',
			'secure' => 'true',
			'samesite' => 'none',
		];
		header('Set-Cookie: ' . urldecode(http_build_query($cookie, '', ';')));
	}
}

?>

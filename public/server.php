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

/**
 * Chat Client Endpoint
 */
use Slim\Factory\AppFactory;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use SlimChatServer\Settings;
use SlimChatServer\Kernel;
use SlimChatServer\Models\Users;
use SlimChatServer\Models\Dialogs;
use SlimChatServer\Models\MessagesOfDialogs;
use SlimChatServer\Models\UsersOfDialogs;

require __DIR__ . '/../vendor/autoload.php';

$application = AppFactory::create();

require __DIR__ . '/../config/config.php';

$errorMiddleware = $application->addErrorMiddleware(true, true, true);
$errorHandler = $errorMiddleware->getDefaultErrorHandler();
$errorHandler->forceContentType('application/json');

$kernel = new Kernel();
$application->get('/', function(Request $request, Response $response)use($kernel) {
	return $kernel->respond(200, "Slim Chat Server Here", $response);
});
$application->post('/users/login', function(Request $request, Response $response)use($kernel) {
	list('username' => $username, 'password' => $password) = $kernel->decodeJSON($request);
	$users = new Users();
	$result = $users->login($username, $password);
	if($result)
	{
		$code = 201;
		$message = 'Login Succeeded.';
	}
	else
	{
		$code = 401;
		$message = 'Login Failed.';
	}
	return $kernel->respond($code, json_encode([$message]), $response);
});

$application->get('/users', function(Request $request, Response $response)use($kernel) {
	$users = new Users();
	$records = $users->all();
	return $kernel->respond(200, json_encode($records), $response);
});

$application->get('/users/{id:[1-9][0-9]*}', function(Request $request, Response $response)use($kernel) {
	$id = $request->getAttribute("id");
	$users = new Users();
	$record = $users->one($id);
	return $kernel->respond(200, json_encode($record), $response);
});

$application->get('/dialogs', function(Request $request, Response $response)use($kernel) {
	$dialogs = new Dialogs();
	$records = $dialogs->all();
	return $kernel->respond(200, json_encode($records), $response);
});

$application->get('/dialogs/{id:[1-9][0-9]*}', function(Request $request, Response $response)use($kernel) {
	$id = $request->getAttribute("id");
	$dialogs = new Dialogs();
	$record = $dialogs->one($id);
	return $kernel->respond(200, json_encode($record), $response);
});

$application->get('/dialogs/{id:[1-9][0-9]*}/messages', function(Request $request, Response $response)use($kernel) {
	$id = $request->getAttribute("id");
	$messages_of_dialogs = new MessagesOfDialogs();
	$records = $messages_of_dialogs->some(['dialog_id' => $id]);
	return $kernel->respond(200, json_encode($records), $response);
});

$application->get('/dialogs/{id:[1-9][0-9]*}/users', function(Request $request, Response $response)use($kernel) {
	$id = $request->getAttribute("id");
	$users_of_dialogs = new UsersOfDialogs();
	$records = $users_of_dialogs->some(['dialog_id' => $id]);
	return $kernel->respond(200, json_encode($records), $response);
});

$application->post('/dialogs/{dialog_id:[1-9][0-9]*}/message', function(Request $request, Response $response)use($kernel) {
	$dialog_id = $request->getAttribute("dialog_id");
	list('message' => $message) = $kernel->decodeJSON($request);
	$messages_of_dialogs = new MessagesOfDialogs();
	$inputs = [
		'dialog_id' => $dialog_id,
		'user_id' => 1,
		'created' => date("Y-m-d H:i:s"),
		'content' => $message,
	];
	$result = $messages_of_dialogs->add($inputs);
	if($result)
	{
		$code = 201;
	}
	else
	{
		$code = 409;
	}
	return $kernel->respond($code, json_encode(["message" => $message]), $response);
});

$application->run();

?>

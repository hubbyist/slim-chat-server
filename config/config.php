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

use SlimChatServer\Settings;

Settings::call()->init([
	'database' => 'common/slim-chat-server',
	'jwtsecret' => 'q3JPKtJyHAp30gAt1MS6KYjkAXBgJIwD',
	'cookie' => (object) [
		'name' => 'authentication',
		'path' => $application->getBasePath(),
	]
]);

?>

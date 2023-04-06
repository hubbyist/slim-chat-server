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
$paths = [
	'/client.html',
	'/client.css',
	'/client.js',
];
$path = $_SERVER["REQUEST_URI"];
if(in_array($path, $paths))
{
	return false;
}
else
{
	require_once __DIR__ . '/server.php';
}

?>

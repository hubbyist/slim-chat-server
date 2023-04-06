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

use SlimChatServer\Kernel;

require __DIR__ . '/../../vendor/autoload.php';

$kernel = new Kernel();

$claims = ['test' => 'tested'];
$token = $kernel->encodeJWT($claims);
$values = $kernel->decodeJWT($token);

echo sprintf("Testing JWT encode decode for\n:: %s -> %s", json_encode($claims), $token);

assert(json_encode($values) === json_encode($claims), new AssertionError('JWT Claims Mismatched.'));
echo "\n[Passed]\n";

?>

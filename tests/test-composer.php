<?php
require_once __DIR__ . '/../vendor/autoload.php';

use VmgLtd\HlrLookupClient;
use VmgLtd\HlrCallbackHandler;

$client = new HlrLookupClient('username', 'password');

echo "\n\n";
echo $client->submitSyncLookupRequest('+491788735000');
echo "\n\n";

$handler = new HlrCallbackHandler();

echo "\n\n";
echo $handler->parseCallback($_REQUEST);
echo "\n\n";
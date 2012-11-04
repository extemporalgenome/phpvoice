<?php

if(count($argv) < 3) {
	exit("Usage: ${argv[0]} dollars cents\n");
}

$dollars = intval($argv[1]);
$cents = intval($argv[2]);

require("voice.php");

echo "error occurred? " . (voice_erred(voice_dollars($dollars, $cents)) ? "true" : "false") . "\n";

echo "&-sep output: " . implode("&", voice_dollars($dollars, $cents)) . "\n";

function prefixer($w) { return "prefix/$w"; }

echo "&-sep prefixed output: " . implode("&", array_map("prefixer", voice_dollars($dollars, $cents))) . "\n";

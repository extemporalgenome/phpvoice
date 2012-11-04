<?php

// voice_dollars returns an array of single-word strings describing the
// provided dollar and cents amount. If an error occurred, one or more of the
// elements in the returned array will be "error".
function voice_dollars($dollars, $cents) {
	$dollars = (int)$dollars;
	$cents = (int)$cents;
	if($dollars < 0 || $cents < 0 || $cents > 99) {
		return array("error");
	}
	return array_merge(
		voice_number($dollars),
		array("dollars", "and"),
		voice_number($cents),
		array("cents")
	);
}

$_tens = array("error", "error",
               "twenty", "thirty", "forty", "fifty",
               "sixty", "seventy", "eighty", "ninety");
$_ones = array("zero", "one", "two", "three", "four", "five",
               "six", "seven", "eight", "nine", "ten",
               "eleven", "twelve", "thirteen", "fourteen", "fifteen",
               "sixteen", "seventeen", "eighteen", "nineteen");

// voice_number will return an array of speakable strings, as long as
// 0 <= $n <= 999,999. Anything outside that range returns array("error").
function voice_number($n) {
	$n = (int)$n;
	if($n < 0 || $n > 999999) {
		return array("error");
	}
	global $_tens, $_ones;
	$r = array();
	if($n >= 1000) {
		$r = array_merge($r, voice_number($n/1000), array("thousand"));
		$n %= 1000;
	}
	if($n >= 100) {
		$r = array_merge($r, voice_number($n/100), array("hundred"));
		$n %= 100;
	}
	if($n >= 20) {
		array_push($r, $_tens[$n/10]);
		$n %= 10;
	}
	if($n > 0 || empty($r)) {
		array_push($r, $_ones[$n]);
	}
	return $r;
}

// voice_erred takes the output of voice_number or voice_dollars, and returns
// true if an error had occurred, or false otherwise.
function voice_erred($words) {
	return array_search("error", $words) !== FALSE;
}

<?php

function toAscii($string) {
	$result = "";
	for($i = 0; $i<strlen($string); $i++) {
		$result .= dechex(ord($string[$i])) . " ";
	}
	return $result;
}

?>
<?php

function toAscii($string) {
	$result = "";
	for($i = 0; $i<strlen($string); $i++) {
		$result .= dechex(ord($string[$i])) . " ";
	}
	return $result;
}
function getHeader() {
	<?php
	session_start();
	include 'SourceRcon.php';

	if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["submit"] == "Submit") {
		handlePost();
	}
	?>
}

?>
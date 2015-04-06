<?php

function toAscii($string) {
	$result = "";
	for($i = 0; $i<strlen($string); $i++) {
		$result .= dechex(ord($string[$i])) . " ";
	}
	return $result;
}
function getServHeader() {
	session_start();
	include 'SourceRcon.php';
	if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["submit"] == "Submit") {
		handlePost();
	}
}
function getNavHeader() {
	$url='localhost/menu.html';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$html = curl_exec($ch);
	// Get the status code
	echo $html;
	curl_close($ch);
}

?>
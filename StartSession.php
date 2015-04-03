<?php
include 'SourceRcon.php';
include 'usefulFunctions.php';
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST") {
	$_SESSION['address'] = $_POST["address"];
	$_SESSION['port'] = $_POST["port"];
	$_SESSION['password'] = $_POST["password"];

	//test connection by executing a command
	$response = trim(executeCommand($_SESSION['address'],
		$_SESSION['port'], $_SESSION['password'], "echo hi"));
	if("hi" == $response) {
		$_SESSION['valid'] = true;
		
	} else {
		$_SESSION['valid'] = false;
	}
}
?>

<html>
<body>
<form name="Login" method="POST">
	<table>
		<tr><td>Address:</td>	<td><input type="text" name="address"	value="192.168.1.15"></text></td></tr>
		<tr><td>Port:</td>		<td><input type="text" name="port"		value="27015"></text></td></tr>
		<tr><td>Password:</td>	<td><input type="text" name="password"	value="pass"></text></td></tr>
		<tr><td><input type="submit" name="submit" value="Login"></td></tr>
	</table>
</form>
<?php
	if($_SESSION['valid']) {
		echo "Login Successful <a href=\"ExecuteCommand.php\">Continue</a>";
	} else {
		echo "<b><font color=\"red\">Invalid Login</font></a>";
	}
?>
<html>
<body>

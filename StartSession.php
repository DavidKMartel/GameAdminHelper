<?php
include 'SourceRcon.php';
include 'usefulFunctions.php';
session_start();

define("DEFAULT_ADDRESS","10.0.0.150");
define("DEFAULT_PORT","27015");
define("DEFAULT_PASSWORD","pass");


if(!defined($_SESSION['address'])) {
	$_SESSION['address'] = DEFAULT_ADDRESS;
}
if(!defined($_SESSION['port'])) {
	$_SESSION['port'] = DEFAULT_PORT;
}
if(!defined($_SESSION['password'])) {
	$_SESSION['password'] = DEFAULT_PASSWORD;
}
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
		<tr><td>Address:</td>	<td><input type="text" name="address"	value="<?php echo $_SESSION['address'];?>"></text></td></tr>
		<tr><td>Port:</td>		<td><input type="text" name="port"		value="<?php echo $_SESSION['port'];?>"></text></td></tr>
		<tr><td>Password:</td>	<td><input type="text" name="password"	value="<?php echo $_SESSION['password'];?>"></text></td></tr>
		<tr><td><input type="submit" name="submit" value="Login"></td></tr>
	</table>
</form>
<?php
	if($_SESSION['valid']) {
		echo "Login Successful <a href=\"EnterCommand.php\">Continue</a>";
	} else {
		echo "<b><font color=\"red\">Invalid Login</font></a>";
	}
?>
<html>
<body>

<?php
include 'SourceRcon.php';
include 'UsefulFunctions.php';
session_start();

define("DEFAULT_ADDRESS","172.17.0.106");
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

	$_SESSION['valid'] = testLogin($_SESSION['address'],
		$_SESSION['port'], $_SESSION['password']);
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

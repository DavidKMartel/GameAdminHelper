<html>
<body>
	<?php
	session_start();
	include 'SourceRcon.php';

	$command = "";
	$response = "";

	if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["submit"] == "Submit") {
		
		$response = nl2br(handlePost());
	}
	?>

	<a href="StartSession.php">Connect to new server</a>
	<form name="SourceRcon" method="POST">
	<table>
	<tr><td>Command:</td>	<td><input type="text" name="command">
		<input type="submit" name="submit" value="Submit"></td></tr>
	<tr><td>LastCommand:</td><td><?php echo $command; ?></td></tr>
	<tr><td>Response:</td>	<td><?php echo $response; ?></td></tr>
</body>
</html>
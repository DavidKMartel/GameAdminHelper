<html>
<body>
	<?php
	include 'SourceRcon.php';

	handlePost();
	?>

	<form name="SourceRcon" method="POST">
	<table>
	<tr><td>Address:</td>	<td><input type="text" name="address"	value="192.168.1.15"></text></td></tr>
	<tr><td>Port:</td>		<td><input type="text" name="port"		value="27015"></text></td></tr>
	<tr><td>Password:</td>	<td><input type="text" name="password"	value="pass"></text></td></tr>
	<tr><td>Command:</td>	<td><input type="text" name="command">
		<input type="submit" name="submit" value="Submit"></td></tr>
	<tr><td>LastCommand:</td><td><?php echo $command; ?></td></tr>
	<tr><td>Response:</td>	<td><?php echo $response; ?></td></tr>
</body>
</html>
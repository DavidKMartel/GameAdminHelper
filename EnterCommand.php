<html>
<head>

</head>
<body>
	<?php
		session_start();
        include 'UsefulFunctions.php';
		include 'SourceRcon.php';
        //getServHeader();
        getNavHeader();

        if(!defined($_SESSION['command'])) {
			$_SESSION['command'] = "";
		}
		if(!defined($_SESSION['response'])) {
			$_SESSION['response'] = "";
		}
		if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["submit"] == "Submit") {
			$_SESSION['response'] = nl2br(handlePost());
		}
    ?>
	<a href="StartSession.php">Connect to new server</a>
	<form name="SourceRcon" method="POST">
	<table>
	<tr><td>Command:</td>	<td><input type="text" name="command">
		<input type="submit" name="submit" value="Submit"></td></tr>
	<tr><td>LastCommand:</td><td><?php echo $_SESSION['command']; ?></td></tr>
	<tr><td>Response:</td>	<td><?php echo $_SESSION['response']; ?></td></tr>
</body>
</html>
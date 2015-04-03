<?php
error_reporting(E_ALL);

define("SERVERDATA_AUTH",3);
define("SERVERDATA_AUTH_RESPONSE",2);
define("SERVERDATA_EXECCOMMAND",2);
define("SERVERDATA_RESPONSE_VALUE",0);
class SourceRcon
{
	public $host, $port, $password, $id;
	protected $socket;

	function __construct() {
		$this->host = "127.0.0.1";
		$this->port = "27015";
		$this->password = "pass";
		$this->id = 0;
	}

	function sethost($newHost) {
		$this->host = $newHost;
		return $this;
	}

	function setPort($newPort) {
		$this->port = $newPort;
		return $this;
	}

	function setPassword($newPass) {
		$this->password = $newPass;
	}

	function write($type, $body) {
		$message = pack("VVV", strlen($body)+10,$this->id++,$type) . $body . pack("S",0);
		socket_write($this->socket, $message, strlen($message));
	}

	function read() {
		//read in the size of the message
		$size = unpack("V",socket_read($this->socket, 4, PHP_BINARY_READ));

		$response = socket_read($this->socket, $size[1], PHP_BINARY_READ);

		//strip everything but the message
		$response = substr($response, 8, $size[1] - 10);
		return $response;
	}

	function login() {
		$this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if($this->socket == false) {
			echo "<b><font color=\"red\">Failed to open socket</font></b>";
			return false;
		}

		//socket_set_nonblock($this->socket);
		flush();
		if(socket_connect($this->socket, $this->host, $this->port) === false) {
			echo "<b><font color=\"red\">Failed to connect to socket</font></b>";
			return false;
		}

		$this->write(SERVERDATA_AUTH,$this->password);
		$this->read();
		//for some reason, we need to eat extra stuff
		$this->read();
	}

	function execute($command) {
		$this->write(SERVERDATA_EXECCOMMAND, $command);
		return $this->read();
	}

	function close() {
		socket_close($this->socket);
	}
}

$command;
$response;

function executeCommand($address, $port, $password, $command) {
	$rcon = new SourceRcon();
	$rcon->setHost($address);
	$rcon->setPort($port);
	$rcon->setPassword($password);
	$rcon->login();
	$response = $rcon->execute($command);
	$rcon->close();
	return $response;
}

function handlePost() {
	if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["submit"] == "Submit") {
		global $command, $response;
		$address = $_POST["address"];
		$port = $_POST["port"];
		$password = $_POST["password"];
		$command = $_POST["command"];

		$response = executeCommand($address, $port, $password, $command);
	}
}

/*
//sample code for handling post
if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["submit"] == "Submit") {
	global $command, $response;
	$address = $_POST["address"];
	$port = $_POST["port"];
	$password = $_POST["password"];
	$command = $_POST["command"];

	$response = executeCommand($address, $port, $password, $command);
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && $_GET["submit"] == "Submit") {
	global $command, $response;
	$address = $GET["address"];
	$port = $GET["port"];
	$password = $GET["password"];
	$command = $GET["command"];

	$response = executeCommand($address, $port, $password, $command);
}
*/
?>
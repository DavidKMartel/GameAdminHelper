<?php
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
		$message = pack("VVV", strlen($body)+10,$this->id,$type) . $body . pack("S",0);
		socket_write($this->socket, $message, strlen($message));
		return $this->id++;
	}

	/* Reads in one packet.
	 *	@return Array representing the packet
	 *		"SIZE"
	 *		"ID"
	 *		"TYPE"
	 *		"BODY"
	*/
	function readPacket() {
		//read in the size of the packet
		$size = unpack("V",socket_read($this->socket, 4, PHP_BINARY_READ))[1];
		//read rest of packet
		$bytesRead = socket_recv($this->socket, $buffer, $size, MSG_WAITALL);
		//socket_read is non blocking
		//$buffer = socket_read($this->socket, $size, PHP_BINARY_READ);
		$response = unpack("VID/VTYPE/a*BODY",$buffer);

		//remove trailing nulls from body
		$response["BODY"] = substr($response["BODY"],0,-2);
		//add in size
		$response["SIZE"] = $size;
		return $response;
	}

	function login() {
		$this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if($this->socket == false) {
			//echo "<b><font color=\"red\">Failed to open socket</font></b>";
			return false;
		}

		socket_set_option($this->socket,SOL_SOCKET, SO_RCVTIMEO, array("sec"=>1, "usec"=>0));
		if(socket_connect($this->socket, $this->host, $this->port) === false) {
			echo "<b><font color=\"red\">Failed to connect to socket</font></b>";
			return false;
		}

		$this->write(SERVERDATA_AUTH,$this->password);
		$packet = $this->readPacket();
		//for some reason, we need to eat extra stuff
		$packet = $this->readPacket();
		return $packet["TYPE"] == SERVERDATA_AUTH_RESPONSE;
	}

	function execute($command) {
		//there is no way of knowing when the packets will stop
		//it is guaranteed that when a response from the next command is recieved,
		//all of the responses from the previous command have been revieved
		$commId = $this->write(SERVERDATA_EXECCOMMAND, $command);
		$this->write(SERVERDATA_RESPONSE_VALUE, "");
		$packet;
		$body = "";
		do {
			$packet = $this->readPacket();
			$body .= $packet["BODY"];
		} while($packet["ID"] == $commId);
		return $body;
	}

	function close() {
		socket_close($this->socket);
	}
}

$command;
$response;

function testLogin($address, $port, $password) {
	$rcon = new SourceRcon();
	$rcon->setHost($address);
	$rcon->setPort($port);
	$rcon->setPassword($password);
	$success = $rcon->login();
	$rcon->close();
	return $success;
}

function executeCommand($address, $port, $password, $command) {
	$rcon = new SourceRcon();
	$rcon->setHost($address);
	$rcon->setPort($port);
	$rcon->setPassword($password);
	if($rcon->login()) {
		$response = $rcon->execute($command);
		$rcon->close();
		return $response;
	} else {
		$rcon->close();
		return false;
	}
}

function handlePost() {
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		global $command, $response;
		//$address = $_POST["address"];
		//$port = $_POST["port"];
		//$password = $_POST["password"];
		$address = $_SESSION["address"];
		$port = $_SESSION["port"];
		$password = $_SESSION["password"];
		$command = $_POST["command"];

		$response = executeCommand($address, $port, $password, $command);
		return $response;
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
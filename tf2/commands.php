<html>
<head>
	<style type="text/css">
		#commandinfo {
		}
	</style>
	<?php
		include '../UsefulFunctions.php';
		getServHeader();
	?>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
</head>
<body>
	<div id="search">
		<form id="searchbar" action="javascript:listCommands()" method='post'>
			Find:<br>
			(to return all, enter nothing)<br>
			<input type='text' name='searchVal'>
			<input type='submit' value='Submit'>
		</form>
	</div>

	<div id="serverResponse">Response: </div>

	<script type="text/javascript">

	//on page load, execute cvarlist to get the list of commands
	  $(document).ready(function() {
	    listCommands();
	  });

	  function listCommands() {
	  	$.post(
            '/ExecuteCommand.php', 
            { command: "cvarlist " + $('input:text[name=searchVal]').val()},
            function(output){
            	//formatting function prettify(var)
            	prettify(output);
            }
        )
	  }

	  function prettify(res) {
	  	//lines is each line of output from cvarlist
	  	var lines = res.split("\n");
	  	//end is the end html
	  	var end = lines[0] + lines[1];
	  	var i;
	  	for(i=2; i< lines.length; i++) {
	  		end += addHTML(lines[i]);
	  	}
	  	$('#commandlist').html(end);
	  }

	  //addHTML formats each line
	  function addHTML(str) {
	  	//each "column" is broken up by :
	  	var col = str.split(":");
	  	//the actual command is the first one
	  	var command = col[0];

	  	var lineResult = "<div value='";
	  	lineResult+= command.trim() + "' id='"+ command.trim() +"' onclick='expandCommand(this)'>" 
	  		+ command.trim() + "</div>";
	  	return lineResult;
	  }

	  //pulls up the response from executing the command,
	  //a text box, and a submit button to submit command to server
	  function expandCommand(el) {
	  	var divValue = $(el).html();
	  	$.post(
            '/ExecuteCommand.php', 
            { command: divValue},
            function(output){
            	$("#"+divValue).append("<div id='commandinfo'>" + output +"<form id='singleCommand'" +
			  		" action='javascript:getResponse()' method='post'><input type='text' name='command'>" +
			  		"<input type='submit' value='Submit'></div>");
            }
        )
	  	
	  }

	  //to get response from individual commands
	  function getResponse(el) {
	  	$.post(
	  		'/ExecuteCommand.php',
	  		{command: $('input:text[name=command]').val()},
	  		function(output){
            	$("#serverResponse").append(output);
            })
	  }

	</script>

	<div id="commandlist"></div>
	

</body>
</html>
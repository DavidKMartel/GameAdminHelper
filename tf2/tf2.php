<html>
<head>
	<?php
		include '../UsefulFunctions.php';
		getServHeader();
	?>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
</head>
<body>
	

	<script type="text/javascript">
	  $(document).ready(function() {
	  	
	    $.post(
            '/EnterCommand.php', 
            { command: "cvarlist"},
            function(output){
            	prettify(output);
                $('#error').html(output).fadeIn(100);
            }
        )
	  });


	  function prettify(res) {
	  	var end;
	  	var lines = res.split("\n");
	  	for(var command in lines) {
	  		end += addHTML(command);
	  	}
	  }

	  function addHTML(str) {
	  	var col = str.split(":");
	  	var command = col[0];
	  	var lineResult = "<div value='";
	  	lineResult+= command + "' id='"+ command +"' onclick='expandCommand(this)'>" + command + "</div>";
	  	$('commandlist').append(lineResult);
	  }
	  function expandCommand(element) {
	  	var divValue = element.val();
	  	$("#"+divValue).append("<input type='text' name='command'>" + divValue);
	  }

	</script>

	<div id="commandlist">Nothin yet</div>

</body>
</html>
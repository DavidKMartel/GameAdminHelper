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
            '/ExecuteCommand.php', 
            { command: "cvarlist"},
            function(output){
      		$('#commandlist').append(output);
                $('#error').html(output).fadeIn(100);
            }
        )
	  });

	</script>

	<div id="commandlist">Nothin yet</div>

</body>
</html>
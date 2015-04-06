<html>
<head>
    <?php
        include '../UsefulFunctions.php';
        getServHeader();
        getNavHeader();
    ?>
</head>
<body>
    

    <script type="text/javascript">
    //on page load, execute cvarlist to get the list of commands
$(document).ready(function () {
    listCommands();
});

function listCommands() {
    $.post(
        '/ExecuteCommand.php', {
        command: "cvarlist " + $('input:text[name=searchVal]').val()
    },

    function (output) {
        //formatting function prettify(var)
        prettify(output);
    });
}

function prettify(res) {
    //lines is each line of output from cvarlist
    var lines = res.split("\n");
    //end is the end html
    var end = lines[0] + lines[1];
    var i;
    for (i = 2; i < lines.length; i++) {
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
    var lineResult = "<div id='command'><div value='";
    lineResult += command.trim() + "' id='" + command.trim() + "' onclick='expandCommand(this)'>" 
        + command.trim() + "</div><div id='commandinfo' style='display:none'></div></div>";
    return lineResult;
}
//pulls up the response from executing the command,
//a text box, and a submit button to submit command to server
function expandCommand(el) {
    var divValue = $(el).html();
    var info = $("#" + divValue).parent().children("#commandinfo");
    $.post(
        '/ExecuteCommand.php', {
        command: divValue
    },

    function (output) {
        info.html(output + "<form id='singleCommand'" +
            " action='' method='post'><input type='text' name='command'>" +
            "<input type='submit' value='Submit' onclick='getResponse(this, event)'>");
    });
    info.toggle();

}


function getResponse(me, e) {
    e.preventDefault()
    $.post(
        '/ExecuteCommand.php', {
        command: $(me).parent().children("input:text[name=command]").val()
    },

    function (output) {
        $("#serverResponse").prepend((new Date).toUTCString() + "\n" +output);
    });
}
function getMultResponse(me, e) {
    e.preventDefault();

    var arr = $(me).parent().children("textarea").val().split("\n");
    var i;
    for (i = 0; i < arr.length; i++) {
	    $.post(
	        '/ExecuteCommand.php', 
	        { command: arr[i] },
	    function (output) {
	        $("#serverResponse").prepend((new Date).toUTCString() + "\n" + output);
	    });
	}
}
    </script>
    <table id="commandtable">
        <tr>
            <td>
                <div id="commandlist"></div>
            </td>
            <td>
            	<div id="fixedArea">
            		<div id="search">
				        <form id="searchbar" action="javascript:listCommands()" method='post'>
				            Find:<br>
				            (to return all, enter nothing)<br>
				            <input type='text' name='searchVal'>
				            <input type='submit' value='Submit'>
				        </form>
				    </div>
	                <div id="reply">
	                	Response:<br>
	                    <textarea readonly id="serverResponse" rows="15" cols="50"></textarea>
	                </div>
	                <form id="textarea" action="" method="post">
	                    <textarea rows="5" cols="50" id="commandText"></textarea>
	                    <br>
	                    <input type='submit' value='Submit' onclick='getMultResponse(this,event)'>
	                </form>
            	</div>
            </td>
        </tr>
    </table>
    

</body>
</html>
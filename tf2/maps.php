<html>
<head>
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <?php
        include '../UsefulFunctions.php';
        getServHeader();
        getNavHeader();
    ?>
    <style type="text/css">
      #sub {
        position: fixed;
        top:10%;
      }
    </style>
<script type="text/javascript">
function get(){
        alert($('input:radio[name=map]:checked').val());
        $.post(
            '/ExecuteCommand.php',
            { command: "changelevel " + $('input:radio[name=map]:checked').val() },
            function(output){
              alert($('input:radio[name=map]:checked').val());
                $('#error').html(output).fadeIn(100);
            }
        )       
    }

</script>
</head>
<body>
<div id="error">
</div>
<div id="here" style="text-align:left"> 
  <table>
    <tr>
      <td>
    	<form id='mapcommand' action='javascript:alert("success!")' method='post'>
    	</form>
      </td>
      <td>
        <input id="sub" type='submit' value='Submit' onClick='get()'>
      </td>
    </tr>
</div>
<script type="text/javascript">
$(document).ready( function() {

var url='/tf2/List%20of%20maps%20-%20Official%20TF2%20Wiki%20%20%20Official%20Team%20Fortress%20Wiki.html';
var end="";
$.ajax({
       url: url,
       type: 'GET',
       success: function(data) {
        
       		$(data).find('table.grid').each(function() {
       			end+="<table class='maps'>";
       			$(this).find('tr:first-child').each(function() {
       				end+="<tr>"
       				$(this).find('th:lt(4)').each(function(){
       					
				  		end+= "<th>" + $(this).html() + "</th>";
				  		
       			})
       				end+="</tr>";
       			});
	            $(this).find('tr:not(:first-child)').each(function() {
	            	end+="<tr>";
	            	end+="<td><input type='radio' name='map' value ='" + $(this).find('code').html() + "'>";
	            		end+="</input></td>";
		            $(this).find('td:lt(4)').each(function(){
      						$(this).find("img").each(function() {
                    var nonrelpath = $(this).attr('src').replace("./","/tf2/");
                    $(this).attr('src',nonrelpath);
                  });
                  end+="<td>";
    				  		end+=$(this).html();

    				  		end+="</td>";
                  
				  });
		            end+="</tr>";

				});
            });
            end+="</table>";
            $('#mapcommand').append(end);
       }
     });
});
</script>

</body>
</html>
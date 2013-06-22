/**
 * @author Shown
 */
$(document).ready(function(){
	
	
	
	var _uuid=$("div#uuid").html();
	
		
	$("select#times").change(function(){				
		location.href="./index.php/practice/result/"+_uuid+"/"+$(this).val();
		//location.href = "./index.php/practice/resultRoute/?id=" + _uid + "&sort=desc";

	});
});


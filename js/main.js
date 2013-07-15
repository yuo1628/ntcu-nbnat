/**
 * @author Shown
 */

$(document).ready(function() {
	
    $("#login input").keypress(function(event){       
        if (event.keyCode == 13) 
        {
        	login();
        }
     });

});

function login()
{
	
	if($("input#username").val()=="")
	{
		$("input#username").css({"border":"2px solid #ff0000"});
		$("input#password").css({"border":"2px solid #e0e0e0"});
		
		
	}else if($("input#password").val()=="")
	{
		$("input#password").css({"border":"2px solid #ff0000"});
		$("input#username").css({"border":"2px solid #e0e0e0"});
		
	}
	else
	{	
		
		$("input#username").css({"border":"2px solid #e0e0e0"});
		$("input#password").css({"border":"2px solid #e0e0e0"});
		$.post(
			"./index.php/login/login",
			{
				username : $("input#username").val(),
				password : $("input#password").val()
			},
			function(data) {
				
				if($.trim(data)=="error")
				{		
									
					window.location = "./index.php/login/index/error";
					
				}
				else
				{
					window.location = "./index.php/login";
				}
				
				
			}
		);
	}
}

function setSession(str) {
	//alert(str);
	$.post(
		"./index.php/login/setSessionValue",
		{
			key : 'who',
			value : str
		},
		function(data) {
			//alert(data);
			window.location = "./index.php/home";
			
		}
	)
}

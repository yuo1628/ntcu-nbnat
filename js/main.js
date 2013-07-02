/**
 * @author Shown
 */

$(document).ready(function() {
	
});

function login() {
	if($("input#username").val()=="" || $("input#password").val()=="")
	{
		$("input#username").css({"border":"1px solid #ff0000"});
		/*$("div#login ul li span.fontRed").html("請確認帳號與密碼已正確輸入");*/
	}
	else
	{	
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

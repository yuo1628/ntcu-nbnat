/**
 * @author Shown
 */

$(document).ready(function() {
	
});

function login(who) {
	setSession(who);
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

/**
 * @author Shown
 */
function lockToggle(_uuid,_href)
{
	var lock_state = "";
	var p = $(".point[uuid=" + _uuid + "]");
	if($(p).hasClass("lock"))
	{
		lock_state = "unlock";
		$(p).removeClass("lock");
		$(p).addClass(lock_state);
	}
	else
	{
		lock_state = "lock";
		$(p).removeClass("unlock");
		$(p).addClass(lock_state);
	}
	/*
	var lock_state=$("div#lock-"+_uuid).prop("class");
	if(lock_state=="lock")
	{
		lock_state="unlock";
		$("li#li-"+_uuid+" .unlockBtn").show();		
	}
	else
	{
		lock_state="lock";
		$("li#li-"+_uuid+" .unlockBtn").hide();
	}*/
	$.post(
		"./index.php/exam/lockToggle", {
		uuid : _uuid,
		lock : lock_state
	}, function() {
		
		//$("div#lock-"+_uuid).removeClass().addClass(lock_state);
		
	});
			
}

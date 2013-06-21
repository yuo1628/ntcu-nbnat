/**
 * @author Shown
 */
function lockToggle(_uuid)
{
	var _href = location.href;
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
		}
	$.post(_href + "/lockToggle", {
		uuid : _uuid,
		lock:lock_state
	}, function() {
		
		$("div#lock-"+_uuid).removeClass().addClass(lock_state);
		
	});		
}

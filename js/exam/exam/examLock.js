/**
 * @author Shown
 */
function lockToggle(_uuid)
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
	
	$.post(
		"./index.php/exam/lockToggle", {
		uuid : _uuid,
		lock : lock_state
	});
			
}

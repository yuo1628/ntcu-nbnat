/**
 * @author Shown
 */
$(document).ready(function() {
	

});

/*function slide(_id, _state) {
	switch (_state) {
		case "close":
			var _href = location.href;
			$.ajax({
				url : _href + "/findChild/" + _id,
				cache : false,
				dataType : "html",
				success : function(result) {
					$("ul#node li#li-" + _id).after("<li>" + result + "</li>");

				}
			});
			$("ul#node li#li-" + _id).removeClass().addClass("open");

			$("ul#node li#li-" + _id).attr("onclick", "slide('" + _id + "','open')");

			break;
		case "open":
			$("ul#node li#li-" + _id).next("li").remove();
			$("ul#node li#li-" + _id).attr("onclick", "slide('" + _id + "','close')");
			$("ul#node li#li-" + _id).removeClass().addClass("nodeList");
			break;
	}

}
*/
/*
function enter(_id) {
	var _href = location.href;

	$.post(_href + "/findExamList", {
		uid : _id
	}, function(data) {
		$("div#practice").html(data);
	});

}
*/

function openToggle(_uuid,_state)
{
	$("li#li-"+_uuid+" div.btn span.openBtn").removeAttr("onclick");
	if(_state=="open")
	{		
		$("li#li-"+_uuid+" div.btn span.openBtn").parent().after("<div class='setLimit'>限制時間：<input type='radio' checked='checked' name='radio-"+_uuid+"' value='none'>無限期</input><input type='radio' name='radio-"+_uuid +"' value='time'>作答時間達到<input type='text' class='min' style='width:50px;' value='0' />分<input type='text' class='sec' style='width:50px;' value='0' />秒時，系統自動交卷</input><div><span class='greenBtn' onclick=\"sentOpen('"+_uuid+"')\">確認</span><span class='grayBtn' onclick=\"cancelOpen('"+_uuid+"')\">取消</span></div></div>");
				
		$("li#li-"+_uuid+" div.setLimit input[type=text]").bind("click",function(){
			$("li#li-"+_uuid+" div.setLimit input[type=radio]:eq(1)").prop("checked","checked");
		});
	}
	else
	{
		
		$.post("./index.php/exam/closePractice", {
			uuid : _uuid,			
		}, function() {
			$("li#li-"+_uuid+" span.openState").html("開放狀態：<span class='fontRed'>不開放作答</span>");
			$("li#li-"+_uuid+" div.btn span.closeBtn").remove();
			$("li#li-"+_uuid+" div.btn").append("<span class='openBtn blueBtn'>開放作答</span>");
			$("li#li-"+_uuid+" div.btn span.openBtn").attr("onclick","openToggle('"+_uuid+"','open')");
	
		});
	}
	
}
function lockToggle(_uuid)
{
	
	
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
	$.post(
		"./index.php/exam/lockToggle", {
		uuid : _uuid,
		lock : lock_state
	}, function() {
		
		$("div#lock-"+_uuid).removeClass().addClass(lock_state);
		
	});
			
}
function cancelOpen(_uuid)
{
	$("li#li-"+_uuid+" div.setLimit").remove();
	$("li#li-"+_uuid+" div.btn span.openBtn").attr("onclick","openToggle('"+_uuid+"','open')");
	
}



function sentOpen(_uuid)
{
	var _limit=$("li#li-"+_uuid+" div.setLimit input[type=radio]:checked").val();
	var	_time=0;
	var _timeMes="";
	var _min="";
	var _sec="";
		
		
	if(_limit=="time")
	{							
		_min=$.trim($("li#li-"+_uuid+" div.setLimit input[type=text]:eq(0)").val());
		_sec=$.trim($("li#li-"+_uuid+" div.setLimit input[type=text]:eq(1)").val());
		if(isNaN(parseInt(_min))  || isNaN(parseInt(_sec)) )
		{
			alert("請正確輸入所限制之時間！");	
		}
		else
		{
			_time=(_min*60)+(_sec*1);			
			_timeMes=_min+" 分 "+_sec+" 秒";			
		}						
	}
	else
	{
		_timeMes="無期限"
	}
	
	if(_limit=="time" && _time==0)
	{
		alert("請正確輸入所限制之時間！");	
	}
	else
	{	
		
		$.post("./index.php/exam/sentOpen", {
			uuid : _uuid,
			time:_time
		}, function() {
			cancelOpen(_uuid);
			$("li#li-"+_uuid+" span.openState").html("開放狀態：<span class='fontGreen'>開放作答</span>限制時間：<span class='fontBlue'>"+_timeMes+"</span>");
			$("li#li-"+_uuid+" div.btn span.openBtn").remove();
			$("li#li-"+_uuid+" div.btn").append("<span class='closeBtn grayBtn'>取消開放</span>");
			$("li#li-"+_uuid+" div.btn span.closeBtn").attr("onclick","openToggle('"+_uuid+"','close')");
			
		});
	}	
}

function quizManage(_uuid)
{	
	
	//管理試題 取消開放作答
	/*	$.post(_href + "/openToggle", {
			uuid : _uuid,			
		}, function() {
	*/		
	location.href="./index.php/mExam/?id="+_uuid;	
	//	});	
}

/**
 * @author Shown
 */


var _urlUid = getQueryString("id");
$(document).ready(function() {
	
	
	$("select#type").change(function() {
		$("select#type option[value=0]").remove();
		var _type = $(this).val();		

		$.ajax({
			url : "./index.php/mExam/showTemplate/" + _type,
			cache : false,
			dataType : "html",
			success : function(result) {
				$("div#template div#content").html(result);
				$("div#content p").show();
			}
		});
	});
	
	setLockFuncion();
	
	if($("span#openState").attr("class")=="open")
	{
		$("span#openState").html("取消開放");
		var _limitTime=	$("span#limitTime").html();
		if(_limitTime=="0")
		{
			$("span#limitTime").html("限制時間："+"無限期");
		}
		else
		{
			var _min=parseInt(_limitTime/60);
			var _sec=parseInt(_limitTime%60);
			$("span#limitTime").html("限制時間："+_min+"分"+_sec+"秒");
		}		
	}
	else
	{		
		$("span#openState").html("開放試卷");
		$("span#limitTime").remove();		
	}
	
	$("span#openState").click(function(){
		
		$.post("./index.php/exam/closePractice", {
			uuid : _urlUid,			
		}, function() {
			$("span#openState").html("開放試卷");
			$("span#limitTime").remove();	
		
		});
	});
	
	
});

function setLockFuncion()
{
	if($("span#lockState").attr("class")=="lock")
	{
		$("span#lockState").html("試卷解鎖");
		actionCover();
	}
	else
	{
		$("span#lockState").html("試卷上鎖");		
	}
	
	$("span#lockState").click(function(){
		var lock_state=$(this).attr("class");
		if(lock_state=="lock")
		{
			lock_state="unlock";				
		}
		else
		{
			lock_state="lock";			
		}
		$.post(
			"./index.php/exam/lockToggle", {
			uuid : _urlUid,
			lock : lock_state
		}, function() {			
			if(lock_state=="unlock")
			{
				$("div#create div:eq(0)").removeAttr("style");
				$("span#lockState").removeClass().addClass("unlock");
				$("span#lockState").html("試卷上鎖");
			}
			else
			{		
				actionCover();
				$("span#lockState").removeClass().addClass("lock");
				$("span#lockState").html("試卷解鎖");
			}			
		});		
	});
	
}

function actionCover()
{
	$("div#create").css({
			"position":"relative"		
	});
	$("div#create div:eq(0)").css({
		"position":"absolute",
		"width":"100%",		
		"height":"700px",
		"background-color":"white",
		"opacity":"0.5",
		"z-index":"999"
	});
}

function lockToggle()
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

function quizList(_uuid) 
{
	$.post("./index.php/mExam/findExamList", {
		uid : _uuid
	}, function(result) {
		$("div#quizList").html(result);
	});
}

function showTemp() 
{
	$("div#template").show();
}

function cancel() {
	$("div#template").hide();
	$("div#template div#content").empty();
	$("select#type option:eq(0)").prop("selected", true);
	$("select#type").prepend("<option value='0' selected='selected'>請選擇...</option>");
}

function addoption() {
	var _temp = $("table#choose tbody tr:eq(0)").html();
	$("table#choose tbody").append("<tr>" + _temp + "<th><span class='delBtn'>X</span></th></tr>");
	var _index = $("table#choose tbody tr").size() - 2;
	$("table#choose tbody .delBtn:eq(" + _index + ")").bind("click", function() {
		var _sort = $(this).parents("tr").remove();

	});
}

function sendOut() {


	var _ansCount = 0;

	var _trLength = $("table#choose tbody tr").size();
	
	for ( i = 0; i < _trLength; i++) {
		if ($("table#choose tbody tr:eq(" + i + ") input").prop("checked")) {
			_ansCount++;

		}
	}
	var _score = $("#scoreText").val();
	
	if (_ansCount == 0) {
		alert("請指定選項答案!");
	}
	else if(_score=="")
	{
		alert("配分欄位不得為空白!");
	} else {
		
		
		var _topic = $("textarea#topicText").val();
		var _type = $("select#type").val();
		var _tips = new Array();
		$("textarea.tipsText").each(function(i){
			if($(this).val()!=""){
				_tips[i]=$(this).val();
			}
		});
		
		

		var _show = $("input#show").prop("checked");
		var _options = new Array();
		

		for ( i = 0; i < _trLength; i++) {
			_options[i] = new Object();
			_options[i].correct = $("table#choose tbody tr:eq(" + i + ") input").prop("checked");
			_options[i].value = $("table#choose tbody tr:eq(" + i + ") .answerText").val();

		}
		
		$.post("./index.php/mExam/addQuestion", {
			topic : _topic,
			type : _type,
			tips : JSON.stringify(_tips),
			nodes_uuid : _urlUid,
			score : _score,
			_public : _show,
			option : _options
		}, function() {
			
			quizList(_urlUid);
			cancel();
			showTemp();
		});
		
	}
}

function addtips()
{
	var _temp=$("tr.tipsTemp:eq(0)").clone();
	$("td",_temp).removeAttr("colspan");
	var _html=_temp.html();
	var _len=$("tr.tipsTemp").size()+1;
	
	$("#topic").append("<tr class='tipsTemp'>"+_html+"<th><span class='delBtn'>X</span></th></tr>");
	var _index = _len - 2;
	$("table#topic tbody .delBtn:eq(" + _index + ")").bind("click", function() {
		var _sort = $(this).parents("tr").remove();
		tipsSortInit();

	});
	tipsSortInit();
}
function tipsSortInit()
{
	$("table#topic tbody tr.tipsTemp").each(function(i){
		$(this).children("th").first().html("Step "+(i+1));
	});
	
}

function getQueryString( paramName ){ 
　　paramName = paramName .replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]").toLowerCase(); 
　　var reg = "[\\?&]"+paramName +"=([^&#]*)"; 
　　var regex = new RegExp( reg ); 
　　var regResults = regex.exec( window.location.href.toLowerCase() ); 
　　if( regResults == null ) return ""; 
　　else return regResults [1]; 
} 


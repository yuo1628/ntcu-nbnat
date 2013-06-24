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
	setOpenfunction();
	setQuizMetaFunction();
	
});

function setOpenfunction()
{
	if($("span#openBtn").attr("class")=="open")
	{
		$("span#openBtn").html("取消開放");
		var _limitTime=	$("span#limitTime").html();
		if(_limitTime=="0")
		{
			$("span#limitTime").html("試卷開放狀態：<span class='fontGreen'>開放作答中</span>　限制時間：<span class='fontBlue'>無限期</span>");
		}
		else
		{
			var _min=parseInt(_limitTime/60);
			var _sec=parseInt(_limitTime%60);
			$("span#limitTime").html("試卷開放狀態：<span class='fontGreen'>開放作答中</span>　限制時間：<span class='fontBlue'>"+_min+" 分 "+_sec+" 秒</span>");
		}	
		$("span#openBtn").click(function(){
		
			$.post("./index.php/exam/closePractice", {
				uuid : _urlUid,			
			}, function() {
				$("span#openBtn").html("開放試卷");
				$("span#openBtn").attr("onclick","limitTimeSetting()");	
				$("span#limitTime").remove();	
			
			});
		});	
	}
	else
	{		
		$("span#openBtn").html("開放試卷");
		$("span#limitTime").remove();	
		$("span#openBtn").attr("onclick","limitTimeSetting()");	
		
	}	
}

function limitTimeSetting()
{						
	$("span#openBtn").after("<div class='setLimit'>限制時間：<input type='radio' checked='checked' name='radio' value='none'>無限期</input><input type='radio' name='radio' value='time'>作答時間達到<input type='text' class='min' style='width:50px;' value='0' />分<input type='text' class='sec' style='width:50px;' value='0' />秒時，系統自動交卷</input><div><span class='greenBtn' onclick=\"sentLimitTimeSetting()\">確認</span><span class='grayBtn' onclick=\"closeLimitTimeSetting()\">取消</span></div></div>");
			
	$("div.setLimit input[type=text]").bind("keydown",function(){
		$("div.setLimit input[type=radio]:eq(1)").prop("checked","checked");
	});		
	$("span#openBtn").removeAttr("onclick")
}

function closeLimitTimeSetting()
{
	$("div.setLimit").remove();
	$("span#openBtn").attr("onclick","limitTimeSetting()");
}

function sentLimitTimeSetting()
{
	var _limit=$("div.setLimit input[type=radio]:checked").val();
	var	_time=0;
	var _timeMes="";
	var _min="";
	var _sec="";
		
		
	if(_limit=="time")
	{							
		_min=$.trim($("div.setLimit input[type=text]:eq(0)").val());
		_sec=$.trim($("div.setLimit input[type=text]:eq(1)").val());
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
			uuid : _urlUid,
			time:_time
		}, function() {
			$("span#openBtn").after("<span id='limitTime'></span>");
			$("span#limitTime").html("試卷開放狀態：<span class='fontGreen'>開放作答中</span>　限制時間：<span class='fontBlue'>"+_timeMes+"</span>");
		
			closeLimitTimeSetting();
			
		});
		
	}	
}

function setLockFuncion()
{
	if($("span#lockBtn").attr("class")=="lock")
	{
		$("span#lockBtn").html("試卷解鎖");
		actionCover();
	}
	else
	{
		$("span#lockBtn").html("試卷上鎖");		
	}
	
	$("span#lockBtn").click(function(){
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
				$("div#create div#lockCover").removeAttr("style");
				$("span#lockBtn").removeClass().addClass("unlock");
				$("span#lockBtn").html("試卷上鎖");
			}
			else
			{		
				actionCover();
				$("span#lockBtn").removeClass().addClass("lock");
				$("span#lockBtn").html("試卷解鎖");
			}			
		});		
	});
	
}

function actionCover()
{
	$("div#create").css({
			"position":"relative"		
	});
	$("div#create div#lockCover").css({
		"position":"absolute",
		"width":"100%",		
		"height":"700px",
		"background-color":"white",
		"opacity":"0.5",
		"z-index":"999"
	});
}



function quizList(_uuid) 
{
	$.post("./index.php/mExam/findExamList", {
		uid : _uuid
	}, function(result) {
		$("div#quizList").html(result);
		setQuizMetaFunction();
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
			setQuizMetaFunction();
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
	setQuizMetaFunction();
}
function tipsSortInit()
{
	$("table#topic tbody tr.tipsTemp").each(function(i){
		$(this).children("th").first().html("Step "+(i+1));
	});
	
}
function setQuizMetaFunction()
{
	$("div#quizMeta span:eq(0)").html($("table#examList tr").size()-1);
	$("div#quizMeta span:eq(1)").html($("table#examList tr td.public span.fontGreen").size());
	var totalScore=0;
	$("table#examList tr td.public span.fontGreen").each(function(){
		totalScore=totalScore+parseInt($(this).parent().prev("td.score").children("span").html());
		
	});
	$("div#quizMeta span:eq(2)").html(totalScore);
	
	
}
function getQueryString( paramName )
{ 	
　　paramName = paramName .replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]").toLowerCase(); 
　　var reg = "[\\?&]"+paramName +"=([^&#]*)"; 
　　var regex = new RegExp( reg ); 
　　var regResults = regex.exec( window.location.href.toLowerCase() ); 
　　if( regResults == null ) return ""; 
　 else return regResults [1]; 
} 


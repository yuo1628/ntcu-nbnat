/**
 * @author Shown
 */
var _href = location.href;
$(document).ready(function() {
	
	
	if(getQueryString("uuid") != "")
	{
		var uuid = getQueryString("uuid");
		enter(uuid);
	}
	
	//alert(uuid);
	//var o = $(".greenBtn[uuid=" + uuid + "]");
	//alert($(o).attr("uuid"));
	//$(o).click();
	
	
});

function slide(_id, _state) {
	switch (_state) {
		case "close":
			
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

function enter(_uuid) {
	

	$.post("./index.php/practice/findExamList", {
		uid : _uuid
	}, function(data) {
		$("div#practice").html(data);
		$("ul#examList li.topicLi").hide();
		$("ul#examList li.topicLi:eq(0)").show();		
		$("p#examBtn span.previousQuiz").hide();
		isLastQuiz();
		isLastStep(_uuid);
		
		$("div#examMeta span.quizOn").html("1");
		
		_min=parseInt($("div#timer div.min").html(),10);
		_sec=parseInt($("div#timer div.sec").html(),10);
		timedCount();
		
		_limitMin=parseInt($("div#limitTime div.limitMin").html(),10);
		_limitSec=parseInt($("div#limitTime div.limitSec").html(),10);
		start();
		
	});
}


function reStart(_uuid)
{
	if(confirm("點選續考可從上次作答位置繼續作答。\n重新開始作答會刪除上次作答位置，確定仍要重新開始作答?"))
	{
		$.post("./index.php/practice/reStart", {
		uuid : _uuid
		},function(){
			enter(_uuid);
		});
	}
	else
	{
		return false;
	}
}

function continuePractice(_uuid,_ansId,_index)
{
	$.post("./index.php/practice/findExamList", {
		uid : _uuid,
		ansId:_ansId
	},function(data){
		
		$("div#practice").html(data);
		$("ul#examList li.topicLi").hide();
		$("ul#examList li.topicLi:eq("+(_index-1)+")").show();		
		$("p#examBtn span.previousQuiz").hide();
		isLastQuiz();
		
		$("div#examMeta span.quizOn").html(_index);
		
		_min=parseInt($("div#timer div.min").html(),10);
		_sec=parseInt($("div#timer div.sec").html(),10);
		timedCount();
		
		
		
	});
}


function nextQuiz()
{
	$("ul#examList li.topicLi").each(function(i){
		if($(this).is(":visible"))
		{
			$(this).hide();
			$(this).next("li").show();
			var _quizOn=parseInt($("span.quizOn").html());
			_quizOn++;
			$("div#quizNum span.quizOn").html(_quizOn);
			isLastQuiz();
			return false;
		}		
	});	
}
function isLastQuiz()
{
	var _index=$("ul#examList li.topicLi").size()-1;
	if($("ul#examList li.topicLi:eq("+_index+")").is(':visible'))
	{
		$("p#examBtn span.nextQuiz").hide();
	}	
}
function previousQuiz()
{
	$("ul#examList li.topicLi").each(function(i){
		if($(this).is(":visible"))
		{
			$(this).hide();
			$(this).prev("li").show();
			return false;
		}		
	});	
}

function finish(_uuid,_finish,_type,_aid)
{
	var ansArr = new Array();

	$("ul#examList li.topicLi").each(function(i) {		
				
		var ans = new Object();
		var _thisLI = $(this).children("ul").children("li");
		var _id = $(this).attr("id").replace("li-", "");
		ans.topicId = _id;
		var option = new Array();
		_thisLI.each(function() {
			if ($(this).children("input").prop("checked") == true) {
				option.push($(this).children("input").val());
			}
		});
		ans.ans = option;
		ansArr[i] = ans;
		if(!_finish){
			if($(this).is(":visible"))
			{
				return false;
			}	
		}		
	});
	var _min=parseInt($("div#timer div.min").html());
	var _sec=parseInt($("div#timer div.sec").html());
	var _spend=(_min*60)+_sec;
	
	
		$.post("./index.php/practice/addAnswer", {
			answer : JSON.stringify(ansArr),
			spend : _spend,
			finish:_finish,
			uuid : _uuid,
			aid:_aid,
			type:_type
		}, function() {
			if(_finish)
			{
				location.href = "./index.php/practice/resultRoute/" + _uuid + "/desc";
			}
			else
			{
				location.href = "./index.php/practice";
			}		
		});
	
	
}

function result(_uid) {
	
	location.href = "./index.php/practice	/resultRoute/" + _uid + "/asc";
}

function showTips(_id, _state) {
	/*
	 *<div class='arrow-block'><div class='arrow'></div></div>
	 <div class='tips-content'></div>
	 * */
	
	$.post("./index.php/practice/findTips", {
		id : _id		
	}, function(result) {
		if (_state == "close") {
		$("div#tipsBtn-" + _id).after("<div><div class='arrow-block'><div class='arrow'></div></div><div class='tips-content'><div class='tipsMes' id='tipsMes-"+_id+"'>"+result+"</div></div></div>");
		
		$("div#tipsBtn-" + _id+" span.tips").attr("onclick","showTips('"+_id+"','open')");
		$("div#tipsMes-"+_id+" div.tipsFrame").hide();
		$("div#tipsMes-"+_id+" div.tipsFrame:eq(0)").show();
		$("div#tipsMes-"+_id+" div.tipsFrame:eq(0) div.step span.up").remove();

		} else {
			$("div#tipsBtn-" + _id).next("div").remove();
			$("div#tipsBtn-" + _id+" span.tips").attr("onclick","showTips('"+_id+"','close')");
	
		}	
	});
		
}

function nextStep(_id,_index)
{	
	$("div#tipsMes-"+_id+" div.tipsFrame:eq("+_index+")").hide();
	$("div#tipsMes-"+_id+" div.tipsFrame:eq("+(_index+1)+")").show();
	isLastStep(_id);
}

function previousStep(_id,_index)
{	
	$("div#tipsMes-"+_id+" div.tipsFrame:eq("+_index+")").hide();
	$("div#tipsMes-"+_id+" div.tipsFrame:eq("+(_index-1)+")").show();
	isFirstStep(_id);
}

function isLastStep(_id)
{
	var _index=$("div#tipsMes-"+_id+" div.tipsFrame").size()-1;
	if($("div#tipsMes-"+_id+" div.tipsFrame:eq("+_index+")").is(':visible'))
	{
		$("div#tipsMes-"+_id+" div.tipsFrame:eq("+_index+") div.step span.down").remove();
	}	
}

function isFirstStep(_id)
{
	
	if($("div#tipsMes-"+_id+" div.tipsFrame:eq(0)").is(':visible'))
	{
		$("div#tipsMes-"+_id+" div.tipsFrame:eq(0) div.step span.up").remove();
	}
	
}

function getQueryString( paramName ){ 
　　paramName = paramName .replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]").toLowerCase(); 
　　var reg = "[\\?&]"+paramName +"=([^&#]*)"; 
　　var regex = new RegExp( reg ); 
　　var regResults = regex.exec( window.location.href.toLowerCase() ); 
　　if( regResults == null ) return ""; 
　　else return regResults [1]; 
} 

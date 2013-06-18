/**
 * @author Shown
 */
$(document).ready(function() {
	
});

function slide(_id, _state) {
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

function enter(_id) {
	var _href = location.href;

	$.post(_href + "/findExamList", {
		uid : _id
	}, function(data) {
		$("div#practice").html(data);
		$("ul#examList li.topicLi").hide();
		$("ul#examList li.topicLi:eq(0)").show();
		$("p#examBtn span.previousQuiz").hide();
		isLastQuiz();
		
		
	});

}
function nextQuiz()
{
	$("ul#examList li.topicLi").each(function(i){
		if($(this).is(":visible"))
		{
			$(this).hide();
			$(this).next("li").show();
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

function save(_uuid)
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
		if($(this).is(":visible"))
		{
			return false;
		}		
		
	});
	var _min=parseInt($("div#timer div.min").html());
	var _sec=parseInt($("div#timer div.sec").html());
	var _spend=(_min*60)+_sec;
	

	var _href = location.href;
	$.post(_href + "/addAnswer", {
		answer : JSON.stringify(ansArr),
		spend : _spend,
		finish:"false",
		uuid : _uuid
	}, function() {
		location.href = _href ;
	});
	
}

function send(_uuid) {
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
	});
	var _min=parseInt($("div#timer div.min").html());
	var _sec=parseInt($("div#timer div.sec").html());
	var _spend=(_min*60)+_sec;

	var _href = location.href;
	$.post(_href + "/addAnswer", {
		answer : JSON.stringify(ansArr),
		spend : _spend,
		finish:"true",
		uuid : _uuid
	}, function() {
		location.href = _href + "/resultRoute/" + _uuid + "/desc";
	});
	

}

function result(_uid) {
	var _href = location.href;
	location.href = _href + "/resultRoute/" + _uid + "/asc";
}

function showTips(_id, _state) {
	/*
	 *<div class='arrow-block'><div class='arrow'></div></div>
	 <div class='tips-content'></div>
	 * */
	var _href = location.href;
	$.post(_href + "/findTips", {
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

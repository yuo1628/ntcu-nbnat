/**
 * @author Shown
 */
$(document).ready(function(){
	
	
});

function importTemplate(_id)
{
	var _href = location.href;
	$.post(_href + "/editQuizTemplate", {
			id : _id
	}, function(result) {
		$("div#div-" + _id + " div.topic").hide();
		$("div#div-" + _id + " div.topic").next("div").html(result);
		$("tr#topicLi-" + _id + " span.show").attr("onclick", "updateQuiz('" + _id + "')");
		$("tr#topicLi-" + _id + " span.show").html("確定");
		$("tr#topicLi-" + _id + " span.editQuiz").html("取消").attr("onclick", "cancelQuiz('" + _id + "')");		
	});
	
}

function updateQuiz(_id)
{
	var _href = location.href;
	var _tempTopic=$("div#div-" + _id + " input#edit_topicText").val();
	var _tempTips=$("div#div-" + _id + " textarea#tipsTextarea").val();
	var _options=new Array();
	var _len=$("ul#editOption li.oldOption").size();
	//var _option=$()
	for(i=0;i<_len;i++)
	{
		_options[i]=new Object();
		_options[i].id=$("ul#editOption li.oldOption:eq("+i+") input").val();
		_options[i].correct=$("ul#editOption li.oldOption:eq("+i+") input").prop("checked");
		//_options[i].value=$("table#choose tbody tr:eq("+i+") .answerText").val();
		
	}
	alert(_options);
	
	
	/*$.post(_href + "/editQuiz", {
			id : _id,
			data:"topic:"+_tempTopic+",tips:"+_tempTips
	}, function(result) {	
	
		$("div#div-" + _id + " div.topic").html(_tempTopic).show();
		$("div#div-" + _id + " div.topic").next("div").remove();
		$("tr#topicLi-" + _id + " span.show").attr("onclick", "showOption('" + _id + "','close')");
		$("tr#topicLi-" + _id + " span.show").html("展開").next("span").remove();
	});
	*/
}

function cancelQuiz(_id)
{
	$("div#div-" + _id + " div.topic").show();
	$("div#div-" + _id + " div.topic").next("div").remove();
	$("tr#topicLi-" + _id + " span.show").attr("onclick", "showOption('" + _id + "','close')");
	$("tr#topicLi-" + _id + " span.show").html("展開").next("span").remove();
}

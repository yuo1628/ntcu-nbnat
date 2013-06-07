/**
 * @author Shown
 */
$(document).ready(function() {

});

function importTemplate(_id) {
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

function updateQuiz(_id) {
	
	var _len = $("ul#editOption-" + _id + " li").size();
	var _oldLen = $("ul#editOption-" + _id + " li.oldOption").size();
	var _newLen = $("ul#editOption-" + _id + " li.newOption").size();
	
	var _ansCount = 0;
	for ( i = 0; i < _len; i++) {
		if ($("ul#editOption-" + _id + " li:eq(" + i + ") input").prop("checked")) {
			_ansCount++;

		}
	}
	if (_ansCount > 0) {
		var _href = location.href;
		var _tempTopic = $("div#div-" + _id + " textarea.edit_topicText").val();
		var _tempTips = $("div#div-" + _id + " textarea.tipsTextarea").val();
		var _options = new Array();
		var _newOptions = new Array();

		for ( i = 0; i < _oldLen; i++) {
			_options[i] = new Object();
			var o_id = $("ul#editOption-" + _id + " li.oldOption:eq(" + i + ") input").val();
			_options[i].id = o_id;
			_options[i].correct = $("ul#editOption-" + _id + " li.oldOption:eq(" + i + ") input").prop("checked");
			_options[i].value = $("ul#editOption-" + _id + " li.oldOption textarea#option-" + o_id).val();			
		}
		for ( i = 0; i < _newLen; i++) {
			_newOptions[i] = new Object();			
			_newOptions[i].correct = $("ul#editOption-" + _id + " li.newOption:eq(" + i + ") input").prop("checked");
			_newOptions[i].value = $("ul#editOption-" + _id + " li.newOption:eq(" + i + ") textarea.option").val();			
		}
		


		$.post(_href + "/editQuiz", {
			id : _id,			
			data : "topic:" + _tempTopic + ",tips:" + _tempTips,
			option : _options,
			newOption:_newOptions
		}, function(result) {
			
			$("div#div-" + _id + " div.topic").html(_tempTopic).show();
			$("div#div-" + _id + " div.topic").next("div").remove();
			$("tr#topicLi-" + _id + " span.show").attr("onclick", "showOption('" + _id + "','close')");
			$("tr#topicLi-" + _id + " span.show").html("展開").next("span").remove();
			showOption(_id, 'close');
		});
	} else {
		alert("請指定選項答案!");
	}
}

function cancelQuiz(_id) {
	$("div#div-" + _id + " div.topic").show();

	$("div#div-" + _id + " div.topic").next("div").remove();
	$("tr#topicLi-" + _id + " span.show").attr("onclick", "showOption('" + _id + "','close')");
	$("tr#topicLi-" + _id + " span.show").html("展開").next("span").remove();
	showOption(_id, 'close');

}

function removeOption(_id) {
	$("li#oldOption-" + _id).remove();
}
function newOption(_id,_type)
{
	
	if(_type=="choose")
	{		
		var temp='<li class="newOption"><input type="radio" name="item-'+_id+'">';
		temp+='<textarea class="option"></textarea><span class="delBtn">X</span></li>';
		$("ul#editOption-"+_id).append(temp);
		$("ul#editOption-"+_id+" li.newOption span.delBtn").bind("click",function(){
			
			$(this).parents("li").remove();
			
		});
	}
	else if(_type=="multi_choose")
	{
		var temp='<li class="newOption"><input type="checkbox" name="item-'+_id+'">';
		temp+='<textarea class="option"></textarea><span class="delBtn">X</span></li>';
		$("ul#editOption-"+_id).append(temp);
	}	
}


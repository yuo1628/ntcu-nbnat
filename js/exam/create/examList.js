/**
 * @author Shown
 */
var _hrefTemp=location.href.split("/router/");
var _href = _hrefTemp[0];
$(document).ready(function() {
	checkNum();

});


function checkNum() {
	$("tr.topicLi").each(function(i) {
		$("td.number:eq(" + i + ")").html(i + 1);
	});
}

function showOption(_id, _type) {
	if (_type == "close") {
		$("div#div-" + _id + " div.topic").after("<div></div>");
		
		
		$.post(_href + "/findQuizMeta", {
			id : _id
		}, function(result) {
			$("div#div-" + _id + " div.topic").next("div").html(result);
			$("tr#topicLi-" + _id + " span.show").attr("onclick", "showOption('" + _id + "','open')");
			$("tr#topicLi-" + _id + " span.show").html("收合").after("<span class='editQuiz' onclick=\"importTemplate('"+_id+"')\">編輯</span>");
		});
	} else {
		$("div#div-" + _id + " div.topic").next("div").remove();
		$("tr#topicLi-" + _id + " span.show").attr("onclick", "showOption('" + _id + "','close')");
		$("tr#topicLi-" + _id + " span.show").html("展開").next("span").remove();
	}
}

function checkAll() {
	$("input.quiz").prop("checked", $("input.all").prop("checked"));
	decideCheck();
}

function decideCheck() {
	var _checkCount = 0;
	$("input.quiz").each(function(i) {
		if ($("input.quiz:eq(" + i + ")").prop("checked")) {
			_checkCount++;
		}
	});
	if (_checkCount > 0) {
		$("div#tools ul ul li.action").attr("class", "action abled");
		$("div#tools ul ul li.actionScore").attr("class", "actionScore actionScore_abled");
		$("input#batchScoreText").removeAttr("disabled");
	} else {
		$("div#tools ul ul li.action").attr("class", "action unabled");
		$("div#tools ul ul li.actionScore").attr("class", "actionScore actionScore_unabled");
		$("input#batchScoreText").attr("disabled", "disabled");
	}
	var _size = $("input.quiz").size();
	if (_checkCount != _size) {
		$("input.all").prop("checked", false);
	} else if (_checkCount == _size) {
		$("input.all").prop("checked", true);
	}

}

function del(_id) {
	
	$.post(_href + "/delQuiz", {
		id : _id
	}, function() {
		$("tr#topicLi-" + _id).remove();
		checkNum();
	});
}

function batchDel() {
	if(confirm("試題一但刪除即無法復原，確定要刪除嗎？")){
		
	$("input.quiz").each(function() {
		var _this = $(this);

		if (_this.prop("checked")) {
			del(_this.val().replace("exam-", ""));
		}
	});
	}
	
}

function batchShow(_state) {
	$("input.quiz").each(function(i) {
		if ($("input.quiz:eq(" + i + ")").prop("checked")) {
			var _id = $(this).val().replace("exam-", "");
			if (_state == "close" && $("tr#topicLi-" + _id + " span.show").html() == "展開") {
				showOption(_id, _state);
			} else if (_state == "open" && $("tr#topicLi-" + _id + " span.show").html() == "收合") {
				showOption(_id, _state);
			}
		}
	});
}

function batchPublic(_state) {
	
	
	
	$("input.quiz").each(function() {
		var _this = $(this);
		if (_this.prop("checked")) {
			var _id = $(this).val().replace("exam-", "");
			if (_state == "open") {
				var _data =new Object();
				_data["public"]="true";
				$.post(_href + "/editQuiz", {
					id : _id,
					data : JSON.stringify(_data)
				}, function() {
					$("tr#topicLi-" + _id + " td.public").html("<span class='fontGreen'>開放</span>");
				});

			} else {
				var _data =new Object();
				
				_data["public"]="false";
				$.post(_href + "/editQuiz", {
					id : _id,
					data : JSON.stringify(_data)
				}, function() {
					$("tr#topicLi-" + _id + " td.public").html("<span class='fontRed'>不開放</span>");
				});
			}
		}
	});
}

function batchScore() {

	if ($("input#batchScoreText").attr("disabled") != "disabled") {
		var _val = $("input#batchScoreText").val();
		if (_val == "") {
			alert("請正確輸入欲修改的配分!");

		} else {
			if (isNaN(_val)) {
				alert("請輸入數字!");
			} else {
				_val = _val * 100;
				$("input.quiz").each(function() {
					var _this = $(this);
					if (_this.prop("checked")) {
						var _id = $(this).val().replace("exam-", "");
						var _data =new Object();
						_data["score"]=_val;
						$.post(_href + "/editQuiz", {
							id : _id,
							data : JSON.stringify(_data)
						}, function() {
							$("tr#topicLi-" + _id + " td.score span").html(_val/100);
						});
					}
				});
			}
		}
	}
}

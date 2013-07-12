/**
 * @author Shown
 */

var _href = "./index.php/mExam";
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
			var _url=$("div#div-" + _id + " div div.teachMedia").html();
			var _parm=(getQueryStringByUrl(_url,"v"));
			var _html="無";
			if(_url!=""&& _url!=null&& _url!="0"&&_parm)
			{
				_html = "<iframe src=\"http://www.youtube.com/embed/" + _parm + "\" frameborder=\"0\" allowfullscreen></iframe>";
			}
			else if(_url!=""&& _url!=null&& _url!="0"&&!_parm)
			{
				var _urlParm=_url.split("/");				
				_html = "<iframe src=\"http://www.youtube.com/embed/" +_urlParm[_urlParm.length-1]  + "\" frameborder=\"0\" allowfullscreen></iframe>";				
			}
			$("div#div-" + _id + " div div.teachMedia").html(_html);
		});
	} else {
		$("div#div-" + _id + " div.topic").next("div").remove();
		$("tr#topicLi-" + _id + " span.show").attr("onclick", "showOption('" + _id + "','close')");
		$("tr#topicLi-" + _id + " span.show").html("展開").next("span").remove();
	}
}
function getQueryStringByUrl(_url,paramName)
{ 	
　　paramName = paramName.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]").toLowerCase(); 
　　var reg = "[\\?&]"+paramName +"=([^&#]*)"; 
　　var regex = new RegExp( reg ); 
　　var regResults = regex.exec(_url); 
　　if( regResults == null ) return false; 
　 else return regResults [1]; 
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
		setQuizMetaFunction();
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
					setQuizMetaFunction();
				});

			} else {
				var _data =new Object();
				
				_data["public"]="false";
				$.post(_href + "/editQuiz", {
					id : _id,
					data : JSON.stringify(_data)
				}, function() {
					$("tr#topicLi-" + _id + " td.public").html("<span class='fontRed'>不開放</span>");
					setQuizMetaFunction();
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
							
							setQuizMetaFunction();
						});
					}
				});
			}
		}
	}
}

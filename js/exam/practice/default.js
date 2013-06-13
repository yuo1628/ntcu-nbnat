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
	

	var _href = location.href;
	$.post(_href + "/addAnswer", {
		answer : JSON.stringify(ansArr),
		spend : "0",
		uuid : _uuid
	}, function() {
		location.href = _href + "/resultRoute/" + _uuid + "/desc";
	});
	

}

function result(_uid) {
	var _href = location.href;
	location.href = _href + "/resultRoute/" + _uid + "/asc";
}

function showTips(_id, _tips, _state) {
	/*
	 *<div class='arrow-block'><div class='arrow'></div></div>
	 <div class='tips-content'></div>
	 * */
	if (_state == "close") {
		$("div#tipsBtn-" + _id).after("<div><div class='arrow-block'><div class='arrow'></div></div><div class='tips-content'><div class='tipsMes'>"+_tips+"</div></div></div>");
		
		$("div#tipsBtn-" + _id+" span.tips").attr("onclick","showTips('"+_id+"','"+ _tips+"','open')");

	} else {
		$("div#tipsBtn-" + _id).next("div").remove();
		$("div#tipsBtn-" + _id+" span.tips").attr("onclick","showTips('"+_id+"','"+ _tips+"','close')");

	}
}


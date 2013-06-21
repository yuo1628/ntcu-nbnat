/**
 * @author Shown
 */
var _hrefTemp=location.href.split("/router/");
var _href = _hrefTemp[0];
var _urlUid = _hrefTemp[1].replace("/","");
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
		
	
	$.ajax({
		url :"./index.php/mExam/getNodeMes/"+_urlUid,
		cache : false,
		dataType: "json",
		success : function(data){
			$("div#nodeMes div#nodeTitle").html("試卷名稱："+data[0]["name"]);
		
			
		}
	});
	
	
	

});

function quizList(_uuid) {
	
	$.post("./index.php/mExam/findExamList", {
		uid : _uuid
	}, function(result) {
		$("div#quizList").html(result);
	});
}

function showTemp() {
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

/**
 * @author Shown
 */
$(document).ready(function(){
	$(".greenBtn").hide();
	$("select#node").prepend("<option value='0' selected='selected'>請選擇...</option>");
	$("select#node").change(function(){
		var _this=$(this);
		var _childId=$(this).val();
		var _href = location.href;	
		$("select#node").next("select").remove();
		$.ajax({
			url : _href + "/findChild/" + _childId,
			cache : false,
			dataType : "html",
			success : function(result) {
				$("select#node").after(result);
				$(".greenBtn").show();
				
			}		
		});		
	});
	
	$("select#type").change(function(){
		
		var _type=$(this).val();
		var _href = location.href;	
		
		$.ajax({
			url : _href + "/showTemplate/" + _type,
			cache : false,
			dataType : "html",
			success : function(result) {
				$("div#template div#content").html(result);
				$("div#content p").show();
			}		
		});
		
	});
	
});
function showTemp()
{
	$("div#template").show();
	
}
function cancel()
{
	$("div#template").hide();
	$("div#template div#content").empty();
	$("select#type option:eq(0)").prop("selected",true);
}
function addoption()
{
	var _temp=$("table#choose tbody tr:eq(0)").html();
	$("table#choose tbody").append("<tr>"+_temp+"<th><span class='delBtn'>X</span></th></tr>");
	var _index=$("table#choose tbody tr").size()-2;
	delBtnInit(_index);
}
function delBtnInit(_index)
{
	$("table#choose tbody .delBtn:eq("+_index+")").bind("click",function()
	{
		var _sort=$(this).parents("tr").prevAll().size();	
		$("table#choose tbody tr:eq("+_sort+")").remove();
		$("table#choose tbody tr:eq(0) input[type=radio]").prop("checked",true);
	});
} 

function sendOut()
{
	var _nodeId=$("select#child").val();
	var _topic=$("textarea#topicText").val();
	var _tips=$("textarea#tipsText").val();
	var _trLength=$("table#choose tbody tr").size();
	var _options=new Array();
	var _href = location.href;
	
	for(i=0;i<_trLength;i++)
	{
		_options[i]=new Object();
		_options[i].correct=$("table#choose tbody tr:eq("+i+") input").prop("checked");
		_options[i].value=$("table#choose tbody tr:eq("+i+") .answerText").val();
		
	}
	
		
	$.post(_href + "/addQuestion", {
		topic : _topic,
		type :"multiChoose",
		tips:_tips,
		nodes_id:_nodeId,
		option :_options
	}, function(data) {
		
		cancel();
		
	});
	
	
	
	
	
}

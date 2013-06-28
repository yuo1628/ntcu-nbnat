/**
 * @author Shown
 */
$(document).ready(function() {
	
});

var _href = "./index.php/mExam";

function importTemplate(_id) {
	
	$.post(_href + "/editQuizTemplate", {
		id : _id
	}, function(result) {
		$("div#div-" + _id + " div.topic").hide();
		$("div#div-" + _id + " div.topic").next("div").html(result);
		$("tr#topicLi-" + _id + " span.show").attr("onclick", "updateQuiz('" + _id + "')");
		$("tr#topicLi-" + _id + " span.show").html("確定");
		$("tr#topicLi-" + _id + " span.editQuiz").html("取消").attr("onclick", "cancelQuiz('" + _id + "')");
		$("div#div-" + _id + " div div.editTemplate textarea").before("<div class='useTinymce' title='使用文字編輯器'></div><div class='useText' title='文字方塊'></div><div class='tinymceView'></div>");
				
		$("div#div-" + _id + " div div.editTemplate .useTinymce").bind("click",function(){
			var _this=$(this);
			
			$("div#create").after("<div id='tinymceFrame'><div id='tinymceFrameBg'></div><div id='tinymceClose'>X</div><div id='tinymceOk' class='greenBtn'>完成</div><div id='tinymceCon'></div></div>");
			var _oldCon=_this.nextAll("textarea").val();
			$.post(
				"./index.php/mExam/showTinymce",
				{
					content: _oldCon
				},
				function(data)
				{				
					$("div#tinymceFrame div#tinymceCon").html(data);								
					$("div#tinymceClose").click(function(){
						$("div#tinymceFrame").remove();										
					});
					
					$("div#tinymceOk").click(function(){					
						//tinymce.triggerSave();
						var _con=tinymce.activeEditor.getContent();
						
						_this.nextAll("div.tinymceView").html(_con).show();
						_this.nextAll("textarea").val(_con).hide();
						$("div#tinymceFrame").remove();						
					});				
				});
		});
		
		$("div#div-" + _id + " div div.editTemplate div.useText").bind("click",function(){
			var _this=$(this);
			_this.nextAll("div.tinymceView").hide();
			_this.nextAll("textarea").show();
			
		});
	
	
	});

}

function updateQuiz(_id) {
	
	var _len = $("ul#editOption-" + _id + " li").size();
	
	
	var _ansCount = 0;
	for ( i = 0; i < _len; i++) {
		if ($("ul#editOption-" + _id + " li:eq(" + i + ") input").prop("checked")) {
			_ansCount++;

		}
	}
	if (_ansCount > 0) {
		
		var _tempTopic = $("div#div-" + _id + " textarea.edit_topicText").val();
		var _mediaUrl = $("div#div-" + _id + " input.edit_mediaText").val();
		
		
		var _tempTips = new Array();		
		
		$("div#tips-" + _id + " div.tipsDiv").each(function(i){
			if($(this).children("textarea").val()!=""){
			_tempTips[i]=$(this).children("textarea").val();
			}
		});
				
		var _data =new Object();
				
		_data["topic"]=_tempTopic;
		_data["media_url"]=_mediaUrl;
		_data["tips"]=JSON.stringify(_tempTips);
		

		$.post(_href + "/editQuiz", {
			id : _id,	
			data:JSON.stringify(_data)
								
		}, function(result) {
			updateOption(_id);
			$("div#div-" + _id + " div.topic").html(_tempTopic).show();
			$("div#div-" + _id + " div.topic").next("div").remove();
			$("tr#topicLi-" + _id + " span.show").attr("onclick", "showOption('" + _id + "','close')");
			$("tr#topicLi-" + _id + " span.show").html("展開").next("span").remove();
		});
	} else {
		alert("請指定選項答案!");
	}
}
function updateOption(_id)
{
	
	var _oldLen = $("ul#editOption-" + _id + " li.oldOption").size();
	var _newLen = $("ul#editOption-" + _id + " li.newOption").size();
	var _options = new Array();
		var _newOptions = new Array();

		for ( i = 0; i < _oldLen; i++) 
		{			
			var o_id = $("ul#editOption-" + _id + " li.oldOption:eq(" + i + ") input").val();
			var _value=$("ul#editOption-" + _id + " li.oldOption textarea#option-" + o_id).val();
			if(_value!="")
			{
				_options[i] = new Object();
				_options[i].id = o_id;
				_options[i].correct = $("ul#editOption-" + _id + " li.oldOption:eq(" + i + ") input").prop("checked");
				_options[i].value = _value;
			}			
		}
		for ( i = 0; i < _newLen; i++)
		{
			var _value=$("ul#editOption-" + _id + " li.newOption:eq(" + i + ") textarea.option").val();
			
			if(_value!="")
			{
				_newOptions[i] = new Object();			
				_newOptions[i].correct = $("ul#editOption-" + _id + " li.newOption:eq(" + i + ") input").prop("checked");
				_newOptions[i].value = _value;
			}			
		}
		
	$.post(_href + "/editOption", {
			id : _id,			
			option:_options,
			newOption:_newOptions					
		},function(){			
			showOption(_id, 'close');
		});
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
			temp+="<div class='useTinymce' title='使用文字編輯器'></div>";
			temp+="<div class='useText' title='文字方塊'></div>";
			temp+="<div class='tinymceView'></div>";
			temp+='<textarea class="option"></textarea><span class="delBtn">X</span></li>';
		$("ul#editOption-"+_id).append(temp);
		
	}
	else if(_type=="multi_choose")
	{
		var temp='<li class="newOption"><input type="checkbox" name="item-'+_id+'">';
			temp+="<div class='useTinymce' title='使用文字編輯器'></div>";
			temp+="<div class='useText' title='文字方塊'></div>";
			temp+="<div class='tinymceView'></div>";
			temp+='<textarea class="option"></textarea><span class="delBtn">X</span></li>';
		$("ul#editOption-"+_id).append(temp);
		
	}	
	$("ul#editOption-"+_id+" li.newOption span.delBtn").bind("click",function(){
			$(this).parents("li").first().remove();	
	});
	
	var _index=$("ul#editOption-"+_id+ " li").size();
					
	$("ul#editOption-"+_id+ " li:eq("+(_index-1)+") .useTinymce").bind("click",function(){
			var _this=$(this);
			
			$("div#create").after("<div id='tinymceFrame'><div id='tinymceFrameBg'></div><div id='tinymceClose'>X</div><div id='tinymceOk' class='greenBtn'>完成</div><div id='tinymceCon'></div></div>");
			var _oldCon=_this.nextAll("textarea").val();
			$.post(
				"./index.php/mExam/showTinymce",
				{
					content: _oldCon
				},
				function(data)
				{				
					$("div#tinymceFrame div#tinymceCon").html(data);								
					$("div#tinymceClose").click(function(){
						$("div#tinymceFrame").remove();										
					});
					
					$("div#tinymceOk").click(function(){					
						//tinymce.triggerSave();
						var _con=tinymce.activeEditor.getContent();
						
						_this.nextAll("div.tinymceView").html(_con).show();
						_this.nextAll("textarea").val(_con).hide();
						$("div#tinymceFrame").remove();						
					});				
				});
		});
		
		$("ul#editOption-"+_id+ " li:eq("+(_index-1)+") div.useText").bind("click",function(){
			var _this=$(this);
			_this.nextAll("div.tinymceView").hide();
			_this.nextAll("textarea").show();
			
		});
	
}

function removeTips(_index,_id)
{
	$("div.tipsMes div#tipsDiv-" + _index).remove();
	editTipsSortInit(_id);
}

function tipsAppend(_id)
{	

	var temp="<div class='tipsDiv'>";
		temp+="<span class='tipsTopic'></span>";
		temp+="<div class='useTinymce' title='使用文字編輯器'></div>";
		temp+="<div class='useText' title='文字方塊'></div>";
		temp+="<div class='tinymceView'></div>";
		temp+="<textarea class='tipsTextarea'></textarea>";
		temp+="<span class='delBtn'>X</span>";
		temp+="</div>";
	
	var _index=$("div#tips-"+_id+" div.tipsDiv").size();
	
	
		$("div#tips-"+_id).append(temp);
		$("div#tips-"+_id+" div.tipsDiv span.delBtn").bind("click",function(){
			
			$(this).parents("div").first().remove();
			editTipsSortInit(_id);
		});
		
				
		$("div#tips-"+_id+" div.tipsDiv:eq("+_index+") .useTinymce").bind("click",function(){
			var _this=$(this);
			
			$("div#create").after("<div id='tinymceFrame'><div id='tinymceFrameBg'></div><div id='tinymceClose'>X</div><div id='tinymceOk' class='greenBtn'>完成</div><div id='tinymceCon'></div></div>");
			var _oldCon=_this.nextAll("textarea").val();
			$.post(
				"./index.php/mExam/showTinymce",
				{
					content: _oldCon
				},
				function(data)
				{				
					$("div#tinymceFrame div#tinymceCon").html(data);								
					$("div#tinymceClose").click(function(){
						$("div#tinymceFrame").remove();										
					});
					
					$("div#tinymceOk").click(function(){					
						//tinymce.triggerSave();
						var _con=tinymce.activeEditor.getContent();
						
						_this.nextAll("div.tinymceView").html(_con).show();
						_this.nextAll("textarea").val(_con).hide();
						$("div#tinymceFrame").remove();						
					});				
				});
		});
		
		$("div#tips-"+_id+" div.tipsDiv:eq("+_index+") div.useText").bind("click",function(){
			var _this=$(this);
			_this.nextAll("div.tinymceView").hide();
			_this.nextAll("textarea").show();
			
		});
	
		
		
		editTipsSortInit(_id);
}
function editTipsSortInit(_id)
{
	$("div#div-"+_id+" div.tipsDiv").each(function(i){
		$(this).children("span").first().html("Step "+(i+1));		
		
	});
}
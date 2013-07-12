/**
 * @author Shown
 */
$(document).ready(function(){	
	$("div#template textarea").before("<div class='useTinymce' title='使用文字編輯器'></div><div class='useText' title='文字方塊'></div><div class='tinymceView'></div>");
	
	$("table#choose tbody tr:eq(0) input[type=checkbox]").prop("checked",true);
	$("div.useTinymce").click(function(){
		var _this=$(this);
		
		$("div#create").after("<div id='tinymceFrame'><div id='tinymceFrameBg'></div><div id='tinymceClose'>X</div><div id='tinymceOk' class='greenBtn'>完成</div><div id='tinymceCon'></div></div>");
		var _oldCon=_this.nextAll("textarea").val();
		$.post(
			"./index.php/mExam/showTinymce",
			{
				content: _oldCon,
				type:"fill"
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
					var stuff_start="\/\\*_";
					var stuff_start_temp=new RegExp(stuff_start,"g");
					var stuff_end="_\\*\/";
					var stuff_end_temp=new RegExp(stuff_end,"g");
					var _conBox=_con.replace(stuff_start_temp,"<label class='stuffbox'>").replace(stuff_end_temp,"</label>");
					
					_this.nextAll("div.tinymceView").html(_conBox).show();
					_this.nextAll("textarea").val(_con).hide();
					$("div#tinymceFrame").remove();	
					
				});
				
				
			});
	});
	
	$("div.useText").click(function(){
		var _this=$(this);
		_this.nextAll("div.tinymceView").hide();
		_this.nextAll("textarea").show();
		
	});
});
function stuffSendOut() 
{
	
	var _trLength=$("div.tinymceView p span.stuffbox").size();	
	var _score = $("#scoreText").val();
	var _topic = $("textarea#topicText").val();
	var _type = $("select#type").val();
	var _url = $("input#mediaUrl").val();
	
	var _tips = new Array();
	$("textarea.tipsText").each(function(i){
		if($(this).val()!=""){
			_tips[i]=$(this).val();
		}
	});		

	var _show = $("input#show").prop("checked");	
	
	var _con=_topic;
	var stuff_start="\/\\*_";
	var stuff_start_temp=new RegExp(stuff_start,"g");
	var stuff_end="_\\*\/";
	var stuff_end_temp=new RegExp(stuff_end,"g");
	var _conBox=_con.replace(stuff_start_temp,"<label class='stuffbox'>").replace(stuff_end_temp,"</label>");
	
	$.post("./index.php/mExam/addQuestion", {
		topic : _conBox,
		type : _type,
		tips : JSON.stringify(_tips),
		nodes_uuid : _urlUid,
		score : _score,
		url:_url,
		_public : _show,
		option : ""
	}, function() {
		
		quizList(_urlUid);
		cancel();
		showTemp();
		setQuizMetaFunction();
		
	});	
	
}



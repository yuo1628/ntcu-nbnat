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
	
	$("div.useText").click(function(){
		var _this=$(this);
		_this.nextAll("div.tinymceView").hide();
		_this.nextAll("textarea").show();
		
	});
});




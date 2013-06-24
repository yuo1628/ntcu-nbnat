/**
 * @author Shown
 */
$(document).ready(function(){	
	$("textarea").before("<div class='useTinymce' title='使用文字編輯器'></div>");
	$("table#choose tbody tr:eq(0) input[type=radio]").prop("checked",true);
	
	$("div.useTinymce").click(function(){
		
		$("div#create").after("<div id='tinymceFrame'><div id='tinymceFrameBg'></div><div id='tinymceCon'></div></div>");
		$.ajax(
			{
				url:"./index.php/mExam/showTinymce",
				dataType: "html"
			})
			.done(function(data)
			{				
				$("div#tinymceFrame div#tinymceCon").html(data);
				
			});
		
	});
	
});



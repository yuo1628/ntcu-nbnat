/**
 * @author Shown
 */
$(document).ready(function(){
	
	var _href = location.href;
	var _hrefArr=_href.split('/practice/');
	var _uuid=$("div#uuid").html();
	var _url=_hrefArr[0];
	
	
	
	$("select#times").change(function(){
				
		location.href=_url+"/practice/result/"+_uuid+"/"+$(this).val();
	});
});


/**
 * @author Shown
 */
$(document).ready(function(){
	
});

function kmList()
{
	var t_id="";
	var sub_id="";

	if($("input[type=checkbox]:checked").size()>0)
	{
		$("input[type=checkbox]:checked").each(function()
		{
			var _index=$(this).val();
			switch(_index)
			{
				case "teacher":
					t_id=$("select#teacherSelect").val();
					break;
				case "subject":
					sub_id=$("select#subjectSelect").val();
					break;
			}		
		});
		
		$.post("./index.php/map/kmList",
		{
			tId:t_id,
			subjectId:sub_id
		},
		function(data){
			
			if($.trim(data)=="empty")
			{
				$("div#kmList").html("無查詢結果");
			}
			else
			{	$("div#kmList").html("<ul></ul>")			
				$.each(data,function(i,j){
					$("div#kmList ul").append("<li onclick=\"openKm('"+j.id+"')\">"+j.id+"</li>");
					
					
					
					
				});
				
			}
		},"json");
	}
	else
	{
		alert("至少選擇一個查詢項目!");
	}
	
}

function openKm(_id)
{
	location.href="./index.php/map/map?id="+_id;
}

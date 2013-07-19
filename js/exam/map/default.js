/**
 * @author Shown
 */
$(document).ready(function(){

	var showText=function(){

		$("select#subjectSelect").hide();
		$(this).before("<input type=\"text\" id=\"subText\"></input>");
		$(this).html("取消").unbind("click").bind("click",function(){
			$("select#subjectSelect").show();
			$("input#subText").remove();
			$(this).html("建立科目").unbind("click").bind("click",showText);
		});
	};
	$("span#subTextToggle").bind("click",showText);
	$("select#typeSelect").change(function(){
		var _this=$("select#typeSelect");
		if(_this.val()!=0)
		{
			if(_this.val()==13)
			{
				$("select#gradeSelect option[value=4]").show();
			}
			else
			{
				$("select#gradeSelect option[value=4]").hide();
			}

			$("select#gradeSelect option[value=5]").hide();
			$("select#gradeSelect option[value=6]").hide();
		}
		else
		{
			$("select#gradeSelect option[value=4]").show();
			$("select#gradeSelect option[value=5]").show();
			$("select#gradeSelect option[value=6]").show();
		}
	});

});

function kmList()
{
	var t_id="";
	var sub_id="";
	var gra_id="";

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
				case "grade":
					gra_id=$("select#gradeSelect").val();
					break;
			}
		});

		$.post("./index.php/map/kmList",
		{
			tId:t_id,
			subjectId:sub_id,
			grade:gra_id
		},
		function(data){

			if($.trim(data)=="empty")
			{
				$("div#kmList").html("無查詢結果");
			}
			else
			{
				$("div#kmList").html("<ul></ul>")
				$.each(data,function(i,j){
					var liCon="<li><span>科目："+j.subjectName+"</span><span>年級：";
					if(parseInt(j.grade)<=6)
					{
						liCon+="國小 "+j.grade+" 年級";
					}
					else if(j.grade>6 && j.grade<=9)
					{
						liCon+="國中 "+(parseInt(j.grade)-6)+" 年級";
					}else if(j.grade>9 && j.grade<=12)
					{
						liCon+="高中 "+(parseInt(j.grade)-9)+" 年級";
					}else if(j.grade>13 && j.grade<=17)
					{
						liCon+="大學 "+(parseInt(j.grade)-13)+" 年級";
					}
					liCon+="</span><span>建立者："+j.teacherName+"</span>";
					liCon+="<div class='btnList'>";
					liCon+="<span class='blueBtn' onclick=\"openKm('"+j.id+"')\">查看</span>";
					liCon+="<span class='greenBtn' onclick=\"examList('"+j.id+"')\">測驗列表</span>";
					liCon+="</div>";
					liCon+="</li>";
					$("div#kmList ul").append(liCon);
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
	var newwin = window.open();
 	newwin.location= "./index.php/map/map?id="+_id;
	//location.href="./index.php/map/map?id="+_id;
}
function examManage(_id)
{

 	location.href= "./index.php/exam/index/"+_id;
}
function examList(_id)
{
    var newwin = window.open();
	newwin.location= "./index.php/practice/index/"+_id;

}
function hideKm(_id)
{

	$.post("./index.php/map/hideKm/"+_id,function(){
		$("li#li-"+_id).remove();
	});

}
function createMap()
{
	var _subject;
	var _grade;
	if($("input#subText").length>0)
	{

		$.ajax({
			type	:"POST",
			url : "./index.php/map/insertSub",
			async : false,
			data	:
			{
				subject:$("input#subText").val()
			},
			success : function(result) {
				_subject = $.trim(result);
			}
		});
	}
	else
	{
		_subject=$("select#subjectSelect").val();

	}
	_grade=parseInt($("select#typeSelect").val())+parseInt($("select#gradeSelect").val());



	$.ajax({
			type	:"POST",
			url 	: "./index.php/map/create",
			async 	: false,
			data	:
			{
				subjectId:_subject,
				grade:_grade
			},
			success : function(result) {
				openKm($.trim(result));
				location.reload();
			}
	});


}

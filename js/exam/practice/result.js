/**
 * @author Shown
 */
$(document).ready(function(){
	
	if($("select#times option").size()==0)
	{
		location.href="./index.php/login";
		
	}
	
	var _uuid=$("div#uuid").html();
	
		
	$("select#times").change(function(){				
		location.href="./index.php/practice/result/"+_uuid+"/"+$(this).val();
		//location.href = "./index.php/practice/resultRoute/?id=" + _uid + "&sort=desc";

	});
	$("ul#examList li.topicLi").each(function(j){
		var _this=$(this);
		if(_this.children("div.userAnsArr").length>0)
		{
			var _ans=_this.children("div.userAnsArr").html();
			var t=$.parseJSON(_ans);
			for(var i=0;i<t.length;i++)
			{
				var q=$("ul#examList li.topicLi:eq("+j+") div.topic label.stuffbox:eq("+i+")");
				var a=t[i];
				if(q.html()==a)
				{
					
					q.css({"color":"green"});
				}
				else
				{
					
					$("ul#examList li.topicLi:eq("+j+") span.score span").html("0");
					q.prepend("<span class='wrong' style='text-decoration:line-through;color:green;'>"+a+"</span>");
				}
				//$("ul#examList li.topicLi:eq("+j+") div.topic label.stuffbox:eq("+i+")").html(t[i]);
			}
			if($("ul#examList li.topicLi:eq("+j+") div.topic label.stuffbox span.wrong").size()==0)
			{
				$("span#correct").html(parseInt($("span#correct").html()+1));
				$("span#score").html(parseInt($("span#score").html())+parseInt($("ul#examList li.topicLi:eq("+j+") span.score span").html()));
			}
		}
		
	});
});


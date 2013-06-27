/**
 * @author Shown
 */
$(document).ready(function() {
	var _schoolMeta=new Array();
			_schoolMeta[0]="<tr class='schoolMetaTemp'><th>學校地址</th><td id='schoolAddress'><input type='text'/></td></tr>";
			_schoolMeta[1]="<tr class='schoolMetaTemp'><th>學校電話</th><td id='schoolPhone' level='4'><input type='text'/></td></tr>";
		
	var inputToggle = function() {
		var _this = $(this);
		var _select = _this.prev("select");
		var _id = _select.attr("id").replace("Select", "");
		var _level=_this.parents("td").attr("level");		
		
		_select.remove();
		_this.before("<input type='text' id='" + _id + "Text' />");
		
		var _itemOldCon=new Array();
		$("div#member table tr").each(function(i){
			var _this=$(this);
			if(_this.children("td").attr("level")>_level)
			{
				var _itemId=_this.children("td").attr("id");
				_itemOldCon[i]=_this.children("td").html();
				_this.children("td").html("<input type='text' id='"+_itemId+"Text'/>");
			}
			
		});		
		if(_level<=2)
		{
			_this.parents("tr").after(_schoolMeta);
		}
		
		_this.unbind("click");		
		_this.html("取消").bind("click", function() {
			$("input#" + _id + "Text").remove();
			_this.before(_select);
			_this.unbind("click").html("新增選項").bind("click", inputToggle);
			if(_level<=2)
			{
				$("tr.schoolMetaTemp").remove();
			}			
			$("div#member table tr").each(function(i){
				var _this=$(this);
				if(_this.children("td").attr("level")>_level)
				{							
					_this.children("td").html(_itemOldCon[i]);
					$("span.inputNewText").bind("click", inputToggle);
				}					
			});	
					
		});		
	};
	
	$("span.inputNewText").bind("click", inputToggle);
	
	if($("table tr td#schoolType select#schoolTypeSelect").length>0)
	{
		
	}
	else
	{
		$("table tr td#schoolName").html("<input type=\"text\" id=\"schoolNameText\"/>");
		
		$("table tr td#schoolName").parents("tr").after(_schoolMeta);		
	}
	
});


function createMember()
{
	var _cityPk="";
	var _cityName="";
	var school_type;
	var school_name;
	var school_address;
	var school_phone;
	
	
	if($("select#schoolNameSelect").length>0)
	{
		school_name=$("select#schoolNameSelect").val();
	}
	else
	{
		school_name=$("select#schoolNameText").val();
	}
	if($("select#schoolTypeSelect").length>0)
	{
		school_type=$("select#schoolTypeSelect").val();
	}
	else
	{
		school_type=$("select#schoolTypeText").val();
	}
	if($("select#citySelect").length>0)
	{
		_cityPk=$("select#citySelect").val();
	}
	else
	{		
		_cityName=$("input#cityText").val();				
	}
	/*
	 $.post("./index.php/member/insertCity",{
			city_name:$("input#cityText").val()
		});
	 * */
	
	
}

/**
 * @author Shown
 */
var inputToggle;
var user_rank="0";


$(document).ready(function() {
	settingRank();
	checkPWD();
	if(user_rank=="0") //最高權限管理者
	{	
		inputToggle 	= 	function() {
			var _this 	= 	$(this);
			var _select = 	_this.prev("select");
			var _id 	=	 _this.parents("td").attr("id");
			var _level	=	_this.parents("td").attr("level");		
		
			_select.remove();
			_this.before("<input type='text' id='" + _id + "Text' />");
			
			var _itemOldCon	=	new Array();
			$("div#member table tr").each(function(i){
				var o	=	$(this);
				if(o.children("td").attr("level")>_level)
				{
					var _itemId		=	o.children("td").attr("id");
					_itemOldCon[i]	=	o.children("td").clone();
					o.children("td").html("<input type='text' id='"+_itemId+"Text'/>");
					$("table tr td#schoolAddress input").val("");	
					$("table tr td#schoolPhone input").val("");	
					
				}				
			});				
			_this.unbind("click");		
			_this.html("取消").bind("click", function() 
				{
					$("input#" + _id + "Text").remove();
					_this.before(_select);					
					_this.unbind("click").html("新增選項").bind("click", inputToggle);							
					$("div#member table tr").each(function(i)
					{
						var k	=	$(this);
						if(k.children("td").attr("level")>_level)
						{														
							k.children("td").html(_itemOldCon[i].html());
							selectSchoolMeta();
							optionBindInit();
						}					
					});							
			});		
		};
	
		if($("table tr td#schoolType select#schoolTypeSelect").length>0)
		{
			selectSchoolName();			
		}
		else
		{
			$("table tr td#schoolName").html("<input type=\"text\" id=\"schoolNameText\"/>");				
		}	
		optionBindInit();	
	
		$("table tr[rank=0]").hide();
	}
	else if(user_rank=="1") //一般管理者
	{
		
	}
});	

function checkPWD()
{
	$("input#secondPwd").keyup(function(){
		if($(this).val()!=$("input#password").val())
		{
			$(this).next("span").html("X");
		}else
		{
			$(this).next("span").html("O");
		}
		
	});
}

function settingRank()
{
	var randArr=new Array("管理者","老師","學生");
	var temp="";	
	for (var i = user_rank; i < randArr.length; i++) {
		temp+="<option value='"+(parseInt(i)+1)+"'>";
		temp+=randArr[i];
		temp+="</option>";
	}
	$("select#rank").html(temp);
}

function optionBindInit()
{
	$("table tr td#schoolType select,table tr td#city select").unbind("change").bind("change",function(){
		selectSchoolName();
	});
	
	$("table tr td#schoolName select").unbind("change").bind("change",function(){
		selectSchoolMeta();
	});
	
	$("span.inputNewText").unbind("click").bind("click", inputToggle);
}

function selectSchoolMeta()
{
	if($("table tr td#schoolName select").size()>0){
		var schoolId	=	$("table tr td#schoolName select").val();	
		var key_arr		=	new Array();
			key_arr[0]	=	"school_pk";
		var value_arr	=	new Array();
			value_arr[0]=	schoolId;
			
		$.post("./index.php/member/selectOption",
		{
			key		:key_arr,
			value	:value_arr
		},
		function(result_arr)
		{
			if(result_arr.length>0)
			{
				$.each(result_arr,function(i,j)
				{
					$("table tr td#schoolAddress input").val(j.address);	
					$("table tr td#schoolPhone input").val(j.phone);
				});
			}
		},"json");
	}
}

function selectSchoolName()
{
	var city		=	$("table tr td#city select").val();
	var schoolType	=	$("table tr td#schoolType select").val();
	var key_arr		=	new Array();
		key_arr[0]	=	"school_city_id";
		key_arr[1]	=	"school_type";
	var value_arr	=	new Array();
		value_arr[0]=	city;
		value_arr[1]=	schoolType;		
	
	$.post("./index.php/member/selectOption",
	{
		key		:key_arr,
		value	:value_arr
	},
	function(result_arr)
	{	
		var temp="";	
		if(result_arr.length>0){
			temp="<select>";
			$.each(result_arr,function(i,j){
					temp+="<option value="+result_arr[i].id+">"+result_arr[i].name+"</option>";
			});
			temp+="</select>";
			temp+="<span class='fontGray inputNewText'>新增選項</span>";	
			$("table tr td#schoolName").html(temp);	
			
			selectSchoolMeta();	
			optionBindInit();			
		}	
		else
		{
			temp="<input type=\"text\" id=\"schoolNameText\"/>";
			$("table tr td#schoolName").html(temp);	
			$("table tr td#schoolAddress input").val("");	
			$("table tr td#schoolPhone input").val("");			
		}
			
	},"json");	
}


function createMember()
{
	var	username		=	$("input#username").val(),	
		password		=	$("input#password").val(),		
		_rank			=	$("select#rank").val();
	var _name,
		_sex,
		_birthday,
		_icNum,
		_phone,
		_tel,
		_address,
		_email;		
	var	_cityPk			=	"",
		_cityName		=	"",		
		school_type,
		school_name,
		school_address	=	$("input#schoolAddressText").val(),
		school_phone	=	$("input#schoolPhoneText").val();
		
	
		
	if($("select#schoolNameSelect").length>0)
	{
		school_name		=	$("select#schoolNameSelect").val();		
	}
	else
	{
		school_name		=	$("input#schoolNameText").val();		
	}
	if($("select#schoolTypeSelect").length>0)
	{
		school_type		=	$("select#schoolTypeSelect").val();
	}
	else
	{
		school_type		=	$("input#schoolTypeText").val();
	}
	
	/*	
	if($("select#citySelect").length>0)
	{
		_cityPk			=	$("select#citySelect").val();
		$.post("./index.php/member/insertSchool",{
			school_type		:school_type,
			school_name		:school_name,
			school_address	:school_address,
			school_phone	:school_phone,
			city_id			:_cityPk
		},function(result_school_id){
			alert("insert the school data is success!!");
		});
	}
	else
	{		
		_cityName		=	$("input#cityText").val();		
		$.post("./index.php/member/insertCity",{
			city_name:_cityName
		},function(result_city_id){		
			
			$.post("./index.php/member/insertSchool",{
				school_type		:school_type,
				school_name		:school_name,
				school_address	:school_address,
				school_phone	:school_phone,
				city_id			:$.trim(result_city_id)
			},function(result_school_id){
				alert("insert the city data and the school data is success!!");
			});
			
		});
					
	}
	*/
	/*
	 $.post("./index.php/member/insertCity",{
			city_name:$("input#cityText").val()
		});
	 * */
	
	
}

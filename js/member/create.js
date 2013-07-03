/**
 * @author Shown
 */
var inputToggle;
var user_rank;


$(document).ready(function() {
	
	$.ajax({			
			url		:"./index.php/member/findUserRank",
			async	:false,			
			success	:function(rank)
			{
				user_rank=rank;
			}			
		});
	
	settingRank();
	checkPWD();
		
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
	

});	


function checkRank(_level)
{
	
	if(_level=="1") //最高權限管理者
	{
		$("table tr[rank=0]").hide();
		
	}
	else //一般管理者
	{
		$("table tr[rank=0]").show();		
	}
}
function getClassType()
{
	if($("select#schoolNameSelect").length>0)
	{
		var schoolId		=	$("select#schoolNameSelect").val();
		var key_arr			=	new Array();
			key_arr[0]		=	"class_school_id";
		var value_arr		=	new Array();
			value_arr[0]	=	schoolId;
		var class_type		=	new Array();
							
		$.post("./index.php/member/selectClassOption",
		{
			key		:key_arr,
			value	:value_arr
		},
		function(result_arr)
		{				
			if(result_arr.length>0)
			{
				$("td#classType").html("<select id='classTypeSelect'></select><span class='fontGray inputNewText'>新增選項</span>");
				$("td#classType span").unbind("click").html("新增選項").bind("click", inputToggle);							
				$.each(result_arr,function(i,j)
				{
					if($.inArray(j.type,class_type)<0){
						class_type[i]	=	j.type;
						$("select#classTypeSelect").append("<option value='"+j.type+"'>"+j.type+"</option>");					
					}				
				});
				getClassGrade();
				
				$("select#classTypeSelect").bind("change",function(){
					getClassGrade();
				});
			}
			else
			{
				$("td#classType").html("<input type='text' id='classTypeText'/>");
				$("td#classGrade").html("<input type='text' id='classGradeText'/>");
				$("td#className").html("<input type='text' id='classNameText'/>");					
			}
		},"json");
	}
	else
	{
		$("td#classType").html("<input type='text' id='classTypeText'/>");
		$("td#classGrade").html("<input type='text' id='classGradeText'/>");
		$("td#className").html("<input type='text' id='classNameText'/>");		
	}
	
}
function getClassGrade()
{
	var schoolId		=	$("select#schoolNameSelect").val(),
		class_type		=	$("select#classTypeSelect").val();
	
	var key_arr			=	new Array();
		key_arr[0]		=	"class_school_id",
		key_arr[1]		=	"class_type";
	var value_arr		=	new Array();
		value_arr[0]	=	schoolId,
		value_arr[1]	=	class_type;
	var class_grade		=	new Array();
	
	$.post("./index.php/member/selectClassOption",
	{
		key		:key_arr,
		value	:value_arr
	},
	function(result_arr)
	{				
		if(result_arr.length>0)
		{
			$("td#classGrade").html("<select id='classGradeSelect'></select><span class='fontGray inputNewText'>新增選項</span>");
			$("td#classGrade span").unbind("click").html("新增選項").bind("click", inputToggle);							
				
			$.each(result_arr,function(i,j)
			{	
				if($.inArray(j.grade,class_grade)<0){
					class_grade[i]=j.grade;
					$("select#classGradeSelect").append("<option value='"+j.grade+"'>"+j.grade+"</option>");					
				}				
			});
			getClassName();
		}		
	},"json");	
	
}

function getClassName()
{
	var schoolId		=	$("select#schoolNameSelect").val(),
		class_type		=	$("select#classTypeSelect").val(),
		class_grade		=	$("select#classGradeSelect").val();
	
	var key_arr			=	new Array();
		key_arr[0]		=	"class_school_id",
		key_arr[1]		=	"class_type",
		key_arr[2]		=	"class_grade";
	var value_arr		=	new Array();
		value_arr[0]	=	schoolId,
		value_arr[1]	=	class_type,
		value_arr[2]	=	class_grade;

	
	$.post("./index.php/member/selectClassOption",
	{
		key		:key_arr,
		value	:value_arr
	},
	function(result_arr)
	{				
		if(result_arr.length>0)
		{
			$("td#className").html("<select id='classNameSelect'></select><span class='fontGray inputNewText'>新增選項</span>");
			$("td#className span").unbind("click").html("新增選項").bind("click", inputToggle);							
			
			$.each(result_arr,function(i,j)
			{				
				$("select#classNameSelect").append("<option value='"+j.id+"'>"+j.name+"</option>");					
			});
		}		
	},"json");	
}

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
	var randArr	=	new Array("管理者","老師","學生");
	var temp	=	"";	
	for (var i = user_rank; i < randArr.length; i++) {
		temp	+=	"<option value='"+(parseInt(i)+1)+"'>";
		temp	+=	randArr[i];
		temp	+=	"</option>";
	}
	$("select#rank").html(temp);
	
	checkRank($("select#rank").val());	
	$("select#rank").bind("change",function()
	{
		checkRank($(this).val());		
	});
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
		var schoolId		=	$("table tr td#schoolName select").val();	
		var key_arr			=	new Array();
			key_arr[0]		=	"school_pk";
		var value_arr		=	new Array();
			value_arr[0]	=	schoolId;
			
		$.post("./index.php/member/selectSchoolOption",
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
					$("table tr td#schoolAddress input").attr("disabled","disabled");	
					$("table tr td#schoolPhone input").attr("disabled","disabled");
				});
			}
		},"json");
		getClassType();
	}
}

function selectSchoolName()
{
	var city			=	$("table tr td#city select").val();
	var schoolType		=	$("table tr td#schoolType select").val();
	var key_arr			=	new Array();
		key_arr[0]		=	"school_city_id";
		key_arr[1]		=	"school_type";
	var value_arr		=	new Array();
		value_arr[0]	=	city;
		value_arr[1]	=	schoolType;		
	
	$.post("./index.php/member/selectSchoolOption",
	{
		key		:key_arr,
		value	:value_arr
	},
	function(result_arr)
	{	
		var temp="";	
		if(result_arr.length>0){
			temp="<select id='schoolNameSelect'>";
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
			$("table tr td#schoolAddress input").removeAttr("disabled");	
			$("table tr td#schoolPhone input").removeAttr("disabled");
			getClassType();	
					
		}
			
	},"json");	
	
}


function createMember()
{
	/*	帳號資料	*/
	var	_rank			=	$("select#rank").val();
	/*	學校資料	*/		
	var	_cityPk			=	"",
		_cityName		=	"",	
		school_pk		=	"",	
		school_type		=	"",
		school_name		=	"",
		school_address	=	"",
		school_phone	=	"";
	/*	班級資料	*/
	var	_class_id		= 	"", 
		class_type		=	"",
		class_grade		=	"",
		class_name		=	"";		
			
	if($("select#citySelect").length>0)
	{
		_cityPk			=	$("select#countrySelect").val();		
	}
	else 
	{		
		_cityName		=	$("input#cityText").val();
				
		$.ajax({
			type	:"POST",
			url		:"./index.php/member/insertCity",
			async	:false,
			data	:
			{
				city_name:_cityName
			},
			success	:function(result_city_id)
			{
				_cityPk=$.trim(result_city_id);
			}			
		});					
	}
	if($("select#schoolTypeSelect").length>0)
	{
		school_type		=	$("select#schoolTypeSelect").val();
	}
	else
	{
		school_type		=	$("input#schoolTypeText").val();
	}
	if($("select#schoolNameSelect").length>0)
	{
		school_pk		=	$("select#schoolNameSelect").val();			
	}
	else
	{
		school_name		=	$("input#schoolNameText").val();
		school_address	=	$("input#schoolAddressText").val(),
		school_phone	=	$("input#schoolPhoneText").val();	
		$.ajax({
			type	:"POST",
			url		:"./index.php/member/insertSchool",
			async	:false,
			data	:
			{
				school_type		:school_type,
				school_name		:school_name,
				school_address	:school_address,
				school_phone	:school_phone,
				city_id			:_cityPk
			},
			success	:function(result_school_id)
			{
				school_pk	=	$.trim(result_school_id);
			}			
		});
	}	
	
	switch(_rank)
	{
		case "1":
			_class_id	=	"0";
			break;
		default:
			if($("select#classNameSelect").length>0)
			{
				_class_id=$("select#classNameSelect").val();
			}
			else
			{
				if($("select#classTypeSelect").length>0)
				{
					class_type=$("select#classTypeSelect").val();
				}
				else
				{
					class_type=$("input#classTypeText").val();
				}
				if($("select#classGradeSelect").length>0)
				{
					class_grade=$("select#classGradeSelect").val();
				}
				else
				{
					class_grade=$("input#classGradeText").val();
				}
				class_name=$("input#classNameText").val();
				
				$.ajax({
					type	:"POST",
					url		:"./index.php/member/insertClass",
					async	:false,
					data	:
					{
						class_type		:class_type,
						class_grade		:class_grade,
						class_name		:class_name,
						class_school_id	:school_pk						
					},
					success	:function(result_class_id)
					{
						_class_id	=	$.trim(result_class_id);
					}			
				});				
			}
			break;			
	}	
	
	var user_value			=	new Object();
		user_value.username	=	$("input#username").val(),
		user_value.password	=	$("input#password").val(),
		user_value.name		=	$("input#name").val(),
		user_value.sex		=	$("input[name=sex]:checked").val(),
		user_value.rank		=	_rank,
		user_value.birthday	=	$("input#birthday").val(),
		user_value.ic_number=	$("input#icNum").val(),
		user_value.phone	=	$("input#phone").val(),
		user_value.tel		=	$("input#tel").val(),
		user_value.address	=	$("input#address").val(),
		user_value.email	=	$("input#email").val(),
		user_value.class_id	=	_class_id;	
		
	$.ajax({
		type	:"POST",
		url		:"./index.php/member/insertUser",
		async	:false,
		data	:
		{	
			value	:user_value
		},
		success	:function(data)
		{			
			alert("insert user data is success!!");
		}					
	});
	
	
	
}

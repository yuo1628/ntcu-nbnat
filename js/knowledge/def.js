/**
 * @author Owner
 * 
 * 如果把存取上個線的物件放在click裡面 ，會無法即時反應lid的情況
 * 
 * 所以下次更動時 改成需雙點兩個才可以畫線 順便建線 不用setline
 */

var pointObjIndex = 0;

//scene
var canvasBoo = false;
var canvasX = 0;
var canvasY = 0;
var downX = 0;
var downY = 0;

//drag
var dragObj;
var dragBoo = false;
var pageX = 0;
var pageY = 0;

//mouse down 
var thisPointObj;

//link btn
var linkBoo = false;

//removeLink btn
var removeLinkObj;

//removeChildLink btn
var removeChildLinkObj;

//removePoint btn
var removePointObj;

//point click
var pointClickObj;

//addline
var lineIndex = 0;
var link1Obj;
var link2Obj;
var linkObjIndex = 0;
var addLinkObj;

//addChildLine
var addChildLinkObj;
var childLink1Obj;
var childLink2Obj;


//statu
var ACTION = 0;
var NO_ACTION = 0
var ADD_LINK = 1;
var ADD_CHILD_LINK = 2
var REMOVE_LINK = 3;
var REMOVE_CHILD_LINK = 4;

//test
var test_json;

//tmp
var tmpPointIndex = 0; 
var tmpLineIndex = 0;

$(function() {
	
	$(".mapBg").width($(document).width());
	$(".mapBg").height($(document).height());
	
	$(".mapBgClose").click(function() {
		$(".mapBg").remove();
		$(".mapContainer").remove();
		$(this).css({
			'display' : 'none'
		})
	})
	
	
	$(".canvas").css({
		'left' : ($("canvas").width() * 0.5) - ($(document).width() * 0.5)
	})
	
	//star effect
	starEffectTime();
	
	
	//setLine();
	//fixX = ($(".line1").width() - $("point1").width()) * 0.5;
	//setLine();
	
	//add point
	$(".addPointBtn").click(function() {
		
		addPointObj();
	})
	
	
	$(document).mousemove(function(e) {
		pageX = e.pageX;
		pageY = e.pageY;
		
		//alert(pageX);
		
		
		/*
		$(".msg").text("");*/
		
		if(dragBoo)
		{
			var lid = $(thisPointObj).attr("lid");
			var ch_lid = $(thisPointObj).attr("ch_lid");
			
			//$(".debug").text("lid: " + lid + " thisPointObj " + thisPointObj);
			
			if(lid != undefined)
			{
				var lidAry = lid.split(",");
				
				
				for(var i = 0; i < lidAry.length; i++)
				{
					var lineObj = $(".line[lid=" + lidAry[i] + "]");
					setLine(lidAry[i], $(lineObj).attr("cid"), $(lineObj).attr("tid"));
				}
				
			}
			
			if(ch_lid != undefined)
			{
				var ch_lidAry = ch_lid.split(",");
				
				for(var i = 0; i < ch_lidAry.length; i++)
				{
					var ch_lineObj = $(".line[ch_lid=" + ch_lidAry[i] + "]");
					setChildLine(ch_lidAry[i], $(ch_lineObj).attr("cid"), $(ch_lineObj).attr("tid"));
				}
			}
			
			setDrag();
			
			//hitTest(thisPointObj);
		}
		else
		{
			if(canvasBoo)
			{
				setSceneDrag();
			}
			
		}
		
	})
	
	
	//event
	$(".canvas").mousedown(function() {
		canvasBoo = true;
		downX = pageX;
		downY = pageY;
		canvasX = parseInt($(this).css('left'));
		canvasY = parseInt($(this).css('top'));
	})
	
	$(".canvas").mouseup(function() {
		canvasBoo = false;
	})
	
	
	
	$(".drag").bind("mousedown", mouseDown);
	$(".drag").bind("mouseup", mouseUp);
	
	$(".linkBtn").click(function() {
		//alert("add line");
		ACTION = ADD_LINK;
		linkBoo = true;
		addLinkObj = pointClickObj;
		$(".msg").text("請選擇節點");
	})
	
	$(".linkChildBtn").click(function() {
		//alert("add line");
		ACTION = ADD_CHILD_LINK;
		linkBoo = true;
		addChildLinkObj = pointClickObj;
		$(".msg").text("請選擇節點");
	})
	
	//removeLink
	$(".removeLinkBtn").click(function() {
		//記錄目前所點選的節點
		ACTION = REMOVE_LINK;
		removeLinkObj = pointClickObj;
	})
	
	$(".removeChildLinkBtn").click(function() {
		ACTION = REMOVE_CHILD_LINK;
		removeChildLinkObj = pointClickObj;
	})
	
	//removePoint
	$(".removePointBtn").click(function() {
		//記錄目前所點選的節點
		removePointObj = pointClickObj;
		removePoint();
	})
	
	
	//check btn
	$(".checkBtn").click(function() {
		setPointVar();
	})
	
	$(".upPosBtn").click(function() {
		displayUpPos();
	})
	
	$(".downPosBtn").click(function() {
		displayDownPos();
	})
	
	$(".saveBtn").click(function() {
		encodeJson();
	})
	
	//一進來就讀
	decodeJson();
	$(".readBtn").click(function() {
		decodeJson();
	})
	
	$(".updBtn").click(function() {
		encodeUpdJson();
	})
	
	$(".groupBtn").click(function() {
		getThisPointGroup();
	})
	
	$(".lockBtn ").click(function() {
		var _href = window.location.href;
		lockToggle(
			$(pointClickObj).attr("uuid"),
			_href
		);
		
		if($(pointClickObj).hasClass("lock"))
		{
			
			$(".lockBtn").removeClass("unlock");
			$(".lockBtn").addClass("lock");
		}
		else
		{
			$(".lockBtn").removeClass("lock");
			$(".lockBtn").addClass("unlock");
		}
	})
	
	$(".gotoTopicBtn").click(function() {
		window.location = "./index.php/practice/?uuid=" + $(pointClickObj).attr("uuid");
		//enter($(pointClickObj).attr("uuid"));
	})
		
})

function starEffect() {
	
	//alert("123");
	
	var ran = Math.floor(Math.random() * ($(".star").size() - 1));
	var obj = $(".star").get(ran);
	
	$(obj).animate({
		'opacity' : '0'
	},300, function() {
		//alert("123");
		starEffectTime();
		$(obj).animate({
			'opacity' : '1'
		},300)
	})
	
	
}

function starEffectTime() {
	var time = setTimeout("starEffect()", 100);
}

function mouseDown(){
	dragObj = $(this);
	dragBoo = true;
	thisPointObj = $(this);
};


function mouseUp(){
	dragObj = null;
	dragBoo = false;
	
};

function pointClick(obj) {
	
	switch(ACTION)
	{
		case ADD_LINK:
			if(linkBoo == true)
			{
				pointLinkObj(obj);
				
			}
		break;	
		case ADD_CHILD_LINK:
			if(linkBoo == true)
			{
				pointChildLinkObj(obj);
				
			}
		break;
		case REMOVE_LINK:
			removeLink(obj);
			break;
		case REMOVE_CHILD_LINK:
			removeChildLink(obj);
		break;
	}
	
		
	//set select this obj css
	
	$(".pointBorderShadow").css({
		'border-color' : '#fff'
	})
	$(obj).find(".pointBorderShadow").animate({
		'border-color' : '#5a9ee9'
	})
	
	/*
	$(".drag").css({
		'border-width' : '5px'
	})
	$(obj).css({
		'border-width' : '5px'
	})*/
	
	//pointClickObj 
	pointClickObj = $(obj);
	setControlVar(obj);
	
	//$(".debug").text("poinClick: " + $(thisPointObj).attr("pid") + " lid: " + $(thisPointObj).attr("lid"));
}

function ajaxProgress(url, data) {
	
	var str = "";
	
	$.ajax({
		xhr: function()
			{
				var xhr = new window.XMLHttpRequest();
				//Upload progress
				xhr.upload.addEventListener("progress", function(evt){
				if (evt.lengthComputable) {
				var percentComplete = evt.loaded / evt.total;
			      //Do something with upload progress
				console.log(percentComplete);
			}
		}, false);
		 //Download progress
		xhr.addEventListener("progress", function(evt){
			if (evt.lengthComputable) {
				var percentComplete = evt.loaded / evt.total;
			     //Do something with download progress
				console.log(percentComplete);
			}
		}, false);
		     return xhr;
		   },
		   type: 'POST',
		   url: url,
		   data: {
				data : data
		   },
		   success: function(data){
		     //Do something success-ish
		     str = data;
		   }
	 });
	 
	 return str;
}

function setControlVar(obj) {
	$(".pointText").val($(obj).find(".pointTextDesc").text());
	
	
	
	if($(obj).hasClass("lock"))
	{
		
		$(".lockBtn").removeClass("unlock");
		$(".lockBtn").addClass("lock");
	}
	else
	{
		$(".lockBtn").removeClass("lock");
		$(".lockBtn").addClass("unlock");
	}
}

function setPointVar() {
	$(pointClickObj).find(".pointTextDesc").text(
		$(".pointText").val()
	)
}

function pointLinkObj(obj) {
	link1Obj = addLinkObj;
	
	$(link1Obj).css({
		'background' : '#f0f0f0'
	})
	
	if($(obj).is(link1Obj))
	{
		alert("請勿選擇自己");
	}
	else
	{
		//判斷是否已連結過
		link2Obj = $(obj);
		var isExist = false;
		var p1_lid = $(link1Obj).attr("lid");
		var p2_lid = $(link2Obj).attr("lid");
		
		if((p1_lid != undefined && p2_lid != undefined) && (p1_lid != "" && p2_lid != ""))
		{
			var p1_lidAry = p1_lid.split(",");
			var p2_lidAry = p2_lid.split(",");
			
			for(var i = 0; i < p1_lidAry.length; i++)
			{
				for(var j = 0; j < p2_lidAry.length; j++)
				{
					if(p1_lidAry[i] == p2_lidAry[j]	)
					{
						isExist = true;
						break;
					}
				}
			}
		}
		
		//var p1_ch_lid = $(link1Obj).attr("ch_lid");
		var p1_ch_lid = $(link1Obj).attr("ch_lid");
		var p2_ch_lid = $(link2Obj).attr("ch_lid");
		
		if((p1_ch_lid != undefined && p2_ch_lid != undefined) && (p1_ch_lid != "" && p2_ch_lid != ""))
		{
			var p1_lidAry = p1_ch_lid.split(",");
			var p2_lidAry = p2_ch_lid.split(",");
			
			for(var i = 0; i < p1_lidAry.length; i++)
			{
				for(var j = 0; j < p2_lidAry.length; j++)
				{
					if(p1_lidAry[i] == p2_lidAry[j]	)
					{
						isExist = true;
						break;
					}
				}
			}
		}
		
		if(isExist)
		{
			alert("兩點已連結過");
		}
		else
		{
			
			$(".msg").text("已連結到此結點, 連結完畢");
			addLine(link1Obj, link2Obj);
		}
		
		//reset
		$(link1Obj).css({
			'background-color' : '#fff'
		})
		$(link2Obj).css({
			'background-color' : '#fff'
		})
		
		//clear
		linkBoo = false;
		//linkObjIndex = 0;
		link1Obj = null;
		link2Obj = null;
		isExist = false;
		ACTION = NO_ACTION;
		
		
	}
}

function pointChildLinkObj(obj) {
	childLink1Obj = addChildLinkObj;
	$(".msg").text("從目前的節點連結到？");
	//linkObjIndex++;
	
	$(childLink1Obj).css({
		'background' : '#f0f0f0'
	})
	
	if($(obj).is(childLink1Obj))
	{
		alert("請勿選擇自己");
	}
	else
	{
		//判斷是否已連結過
		childLink2Obj = $(obj);
		var isExist = false;
		var p1_lid = $(childLink1Obj).attr("ch_lid");
		var p2_lid = $(childLink2Obj).attr("ch_lid");
		
		//alert(p1_lid + " " + p2_lid);
		if((p1_lid != undefined && p2_lid != undefined) && (p1_lid != "" && p2_lid != ""))
		{
			var p1_lidAry = p1_lid.split(",");
			var p2_lidAry = p2_lid.split(",");
			
			for(var i = 0; i < p1_lidAry.length; i++)
			{
				for(var j = 0; j < p2_lidAry.length; j++)
				{
					if(p1_lidAry[i] == p2_lidAry[j]	)
					{
						isExist = true;
						//alert("1");
						break;
					}
				}
			}
		}
		
		var p1_m_lid = $(childLink1Obj).attr("lid");
		var p2_m_lid = $(childLink2Obj).attr("lid");
		if((p1_m_lid != undefined && p2_m_lid != undefined) && (p1_m_lid != "" && p2_m_lid != "")) {
			var ary1 = p1_m_lid.split(",");
			var ary2 = p2_m_lid.split(",");
			for(var i = 0; i < ary1.length; i++)
			{
				for(var j = 0; j < ary2.length; j++)
				{
					if(ary1[i] == ary2[j]	)
					{
						isExist = true;
						alert("2");
						break;
					}
				}
			}
		}
		
		if(isExist)
		{
			alert("兩點已連結過");
		}
		else
		{
			
			$(".msg").text("已連結到此結點, 連結完畢");
			addChildLine(childLink1Obj, childLink2Obj);
		}
		
		//reset
		$(childLink1Obj).css({
			'background-color' : '#fff'
		})
		$(childLink2Obj).css({
			'background-color' : '#fff'
		})
		
		//clear
		linkBoo = false;
		//linkObjIndex = 0;
		childLink1Obj = null;
		childLink2Obj = null;
		isExist = false;
		ACTION = NO_ACTION;
	}
	
	//----
	//link
	//----
	//pointLinkObj(obj);
}


function removeLink(obj) {
	var p1_obj = removeLinkObj;
	var p2_obj = obj;
	var p1_lid = $(removeLinkObj).attr("lid");
	var p2_lid = $(obj).attr("lid");
	var line_id = 0;
	var isExist = false;
	var p1_lidAry;
	var p2_lidAry
	
	
	if(p1_lid != undefined && p2_lid != undefined)
	{
		p1_lidAry = p1_lid.split(",");
		p2_lidAry = p2_lid.split(",");
		
		for(var i = 0; i < p1_lidAry.length; i++)
		{
			for(var j = 0; j < p2_lidAry.length; j++)
			{
				if(p1_lidAry[i] == p2_lidAry[j]	)
				{
					line_id = p1_lidAry[i];
					isExist = true;
					break;
				}
			}
		}
	}
	
	if(isExist)
	{
		//刪除線
		removeLinkPost($(".line[lid=" + line_id + "]"));
		$(".line[lid=" + line_id + "]").remove();
		
		//取消關聯
		var p1_ary = new Array(0);
		var p2_ary = new Array(0);
		
		for(var i = 0; i < p1_lidAry.length; i++)
		{
			if(p1_lidAry[i] != line_id)
			{
				//刪除陣列裡匹配到的元素
				p1_ary.push(p1_lidAry[i]);
				
			}
		}
		
		for(var i = 0; i < p2_lidAry.length; i++)
		{
			if(p2_lidAry[i] != line_id)
			{
				p2_ary.push(p2_lidAry[i]);
				
			}
		}
		
		$(p1_obj).attr("lid", p1_ary.join());
		$(p2_obj).attr("lid", p2_ary.join());
		
		ACTION = NO_ACTION;
		
	}
	else
	{
		alert("與對象並無關聯");
		ACTION = NO_ACTION;
	}
	
}


function removeChildLink(obj) {
	var p1_obj = removeChildLinkObj;
	var p2_obj = obj;
	var p1_lid = $(removeChildLinkObj).attr("ch_lid");
	var p2_lid = $(obj).attr("ch_lid");
	var line_id = 0;
	var isExist = false;
	var p1_lidAry;
	var p2_lidAry
	
	
	if(p1_lid != undefined && p2_lid != undefined)
	{
		p1_lidAry = p1_lid.split(",");
		p2_lidAry = p2_lid.split(",");
		
		for(var i = 0; i < p1_lidAry.length; i++)
		{
			for(var j = 0; j < p2_lidAry.length; j++)
			{
				if(p1_lidAry[i] == p2_lidAry[j]	)
				{
					line_id = p1_lidAry[i];
					isExist = true;
					break;
				}
			}
		}
	}
	
	if(isExist)
	{
		//刪除線
		removeLinkChildPost($(".line[ch_lid=" + line_id + "]"));
		$(".line[ch_lid=" + line_id + "]").remove();
		
		//取消關聯
		var p1_ary = new Array(0);
		var p2_ary = new Array(0);
		
		for(var i = 0; i < p1_lidAry.length; i++)
		{
			if(p1_lidAry[i] != line_id)
			{
				//刪除陣列裡匹配到的元素
				p1_ary.push(p1_lidAry[i]);
				
			}
		}
		
		for(var i = 0; i < p2_lidAry.length; i++)
		{
			if(p2_lidAry[i] != line_id)
			{
				p2_ary.push(p2_lidAry[i]);
				
			}
		}
		
		$(p1_obj).attr("ch_lid", p1_ary.join());
		$(p2_obj).attr("ch_lid", p2_ary.join());
		
		ACTION = NO_ACTION;
		
	}
	else
	{
		alert("與對象並無關聯");
		ACTION = NO_ACTION;
	}
	
}

function removePoint() {
	//line 的tid 已經改為一定是對象
	
	//lid
	
	var p = removePointObj;
	var p_id = $(p).attr("lid");
	
	if(p_id != undefined && p_id != "")
	{
		var lid_ary = p_id.split(",");
		for(var i = 0; i < lid_ary.length; i++)
		{
			var line_obj = $(".line[lid=" + lid_ary[i] + "]");
			
			
			$(".point").each(function() {
				var p_lid = $(this).attr("lid");
				
				if(p_lid != undefined && p_lid != "")
				{
				
					var p_lid_ary = p_lid.split(",");
					var ary = new Array(0);
					
					for(var j = 0; j < p_lid_ary.length; j++)
					{
						if(p_lid_ary[j] != lid_ary[i] && p_lid_ary[j] != "")
						{
							
							ary.push(p_lid_ary[j]);
						}
					}
					
					if(ary.join() == "")
					{
						$(this).removeAttr("lid");
					}
					else
					{
						$(this).attr("lid", ary.join());
					}
				
				}
			})
			removeLinkPost(line_obj);
			$(line_obj).remove();
			
			
		}
		$(p).remove();
	
		removePointPost(p);
		
	}
	//removePointPost(p);
	//$(p).remove();
	
	//ch lid
	var p = removePointObj;
	var p_id = $(p).attr("ch_lid");
	
	if(p_id != undefined && p_id != "")
	{
		var lid_ary = p_id.split(",");
		
		for(var i = 0; i < lid_ary.length; i++)
		{
			var line_obj = $(".line[ch_lid=" + lid_ary[i] + "]");
			
			
			$(".point").each(function() {
				var p_lid = $(this).attr("ch_lid");
				
				if(p_lid != undefined && p_lid != "")
				{
					var p_lid_ary = p_lid.split(",");
					var ary = new Array(0);
					
					for(var j = 0; j < p_lid_ary.length; j++)
					{
						if(p_lid_ary[j] != lid_ary[i] && p_lid_ary[j] != "")
						{
							
							ary.push(p_lid_ary[j]);
						}
					}
					
					if(ary.join() == "")
					{
						$(this).removeAttr("ch_lid");
					}
					else
					{
						$(this).attr("ch_lid", ary.join());
					}
				
				}
			})
			removeLinkChildPost(line_obj);
			$(line_obj).remove();
		
		}
		$(p).remove();
	
		removePointPost(p);
	}
	
	
	
}



function addLine(childObj, targetObj)
{
	
	var cid = $(childObj).attr("pid");
	var tid = $(targetObj).attr("pid");
	var c_lid = $(childObj).attr("lid");
	var t_lid = $(targetObj).attr("lid");
	
	//alert(t_lid);
	if(t_lid != undefined && t_lid != "")
	{
		t_lid += "," + lineIndex;
	}
	else
	{
		t_lid = lineIndex;
	}
	
	if(c_lid != undefined && c_lid != "")
	{
		c_lid += "," + lineIndex;
	}
	else
	{
		c_lid = lineIndex;
	}
	
	
	$(".canvas").append(
		"<div class='line' lid='" + lineIndex + "' cid='" + cid + "' tid='" + tid + "'></div>"
	);
	
	$(childObj).attr("lid", c_lid);
	$(targetObj).attr("lid", t_lid);
	setLine(lineIndex, cid, tid);
	
	lineIndex++;
	linkBoo = false;
	
}


function addChildLine(childObj, targetObj)
{
	
	var cid = $(childObj).attr("pid");
	var tid = $(targetObj).attr("pid");
	var c_lid = $(childObj).attr("ch_lid");
	var t_lid = $(targetObj).attr("ch_lid");
	
	//alert(t_lid);
	if(t_lid != undefined && t_lid != "")
	{
		t_lid += "," + lineIndex;
	}
	else
	{
		t_lid = lineIndex;
	}
	
	if(c_lid != undefined && c_lid != "")
	{
		c_lid += "," + lineIndex;
	}
	else
	{
		c_lid = lineIndex;
	}
	
	
	$(".canvas").append(
		"<div class='line chLine' ch_lid='" + lineIndex + "' cid='" + cid + "' tid='" + tid + "'  ></div>"
	);
	
	$(childObj).attr("ch_lid", c_lid);
	$(targetObj).attr("ch_lid", t_lid);
	setChildLine(lineIndex, cid, tid);
	
	lineIndex++;
	linkBoo = false;
	
}



function setLine(lineId, p1, p2) {
	var line = $(".line[lid=" + lineId + "]");
		
	var p1obj = $(".point[pid=" + p1 + "]");
	var p2obj = $(".point[pid=" + p2 + "]");
	
	$(line).css({
		'width' : get2PointDist($(p1obj), $(p2obj))
	})
	
	var lineW = get2PointDist($(p1obj), $(p2obj));
					
	$(line).css({
		'left' : get2PointXCenter($(p1obj), $(p2obj)) - getFixX(line, p1obj, p2obj),
		'top' : get2PointYCenter($(p1obj), $(p2obj)),
		'transform' : 'rotate(' + get2PointZRotate($(p1obj), $(p2obj)) + 'deg)'
	})
	
	$(line).attr("deg", get2PointZRotate($(p1obj), $(p2obj)));
	
}

function setChildLine(lineId, p1, p2) {
	var line = $(".line[ch_lid=" + lineId + "]");
		
	var p1obj = $(".point[pid=" + p1 + "]");
	var p2obj = $(".point[pid=" + p2 + "]");
	
	$(line).css({
		'width' : get2PointDist($(p1obj), $(p2obj))
	})
	
	var lineW = get2PointDist($(p1obj), $(p2obj));
	//alert($(p1obj).width());
	$(line).css({
		'left' : get2PointXCenter($(p1obj), $(p2obj)) - getFixX(line, p1obj, p2obj),
		'top' : get2PointYCenter($(p1obj), $(p2obj)),
		'transform' : 'rotate(' + get2PointZRotate($(p1obj), $(p2obj)) + 'deg)'
	})
	
	$(line).attr("deg", get2PointZRotate($(p1obj), $(p2obj)));
	
}



/**
 * @param obj = Object
 */
function getFixX(obj, p1,p2) {
	return ($(obj).width() - $(p1).width() + (($(p1).width() * 0.5) - ($(p2).width() * 0.5))) * 0.5 ;
}



/**
 * 求兩點的距離
 * 
 * @param {Object} o1
 * @param {Object} o2
 * @return ab = distance
 */
function get2PointDist(o1, o2) {
	
	var o1x , o1y, o2x, o2y, ab;
	o1x = parseInt($(o1).css("left")) + ($(o1).width() * 0.5) - ($(o2).width() * 0.5);
	o1y = parseInt($(o1).css("top")) + ($(o1).height() * 0.5) - ($(o2).height() * 0.5);
	
	o2x = parseInt($(o2).css("left")) + ($(o2).width() * 0.5) - ($(o1).width() * 0.5);
	o2y = parseInt($(o2).css("top")) + ($(o2).height() * 0.5) - ($(o1).height() * 0.5);
	ab = Math.sqrt(Math.pow(o2x - o1x, 2) + Math.pow(o2y - o1y, 2) )
	+ parseInt($(o1).css("border-left-width")) + parseInt($(o1).css("border-right-width"))
	+ parseInt($(o1).css("border-top-width")) + parseInt($(o1).css("border-bottom-width"))
	+ parseInt($(o2).css("border-left-width")) + parseInt($(o2).css("border-right-width"))
	+ parseInt($(o2).css("border-top-width")) + parseInt($(o2).css("border-bottom-width"))
	;
	
	return ab;
}

/**
 * 求兩點間X的中心點
 * 
 * @param {Object} o1
 * @param {Object} o2
 * @return int dis center point
 */
function get2PointXCenter(o1, o2) {
	var o1x = parseFloat($(o1).css("left"));
	var o2x = parseFloat($(o2).css("left"));
		
	//	
	//
	var center = (o1x + o2x ) * 0.5 ;
	return center;
	
}


/**
 * 求兩點間的斜率所造成的直線旋轉角度
 * 
 * @param {Object} o1
 * @param {Object} o2
 * @return int dis center point
 */
function get2PointYCenter(o1, o2) {
	var o1y = parseInt($(o1).css("top")) + (parseInt($(o1).height()) / 2);
	var o2y = parseInt($(o2).css("top")) + (parseInt($(o2).height()) / 2) ;
		
	var center = (o1y + o2y ) * 0.5;
	return center;
	
}

/**
 * 求兩點間Y的中心點
 * 
 * @param {Object} o1
 * @param {Object} o2
 * @return int dis center point
 */
function get2PointZRotate(o1, o2) {
	var o1x , o1y, o2x, o2y;
	o1x = parseInt($(o1).css("left")) + (($(o1).width() - $(o2).width()));
	o1y = parseInt($(o1).css("top")) + (($(o1).height() - $(o2).height()));
	
	o2x = parseInt($(o2).css("left")) - (($(o2).width() - $(o1).width()) * 0.5) ;
	o2y = parseInt($(o2).css("top")) - (($(o2).width() - $(o1).width()) * 0.5);
		
	//var m = parseFloat((o1y - o2y) / (o1x - o2x))  * 180;
	var m = Math.atan2(o1y - o2y , o1x - o2x) / (Math.PI / 180);
	
	return m;
	
}


function setDrag() {
		
	$(dragObj).css({
		'left' : pageX - ($(dragObj).width() / 2) - parseInt($(".canvas").css("left")),
		'top' : pageY - ($(dragObj).height() / 2) - parseInt($(".canvas").css("top"))
	})
};

function setSceneDrag() {
	//$(".debug").text("&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp setDrag cavasY " + canvasY);
	$(".canvas").css({
		'left' : canvasX + (pageX - downX), 
		'top' : canvasY + (pageY - downY)
	})
}

function hitTest(obj) {
	$(".drag").each(function() {
		
			var x = parseInt($(this).css("left"));
			var y = parseInt($(this).css("top"));
			var thisW = parseInt($(this).width()) ;
			var thisH = parseInt($(this).height()) ;
			
			var oW = parseInt($(obj).width());
			var oH = parseInt($(obj).height());
			var oWhalf = oW;
			var oHhalf = oH;
			var ox = parseInt($(obj).css("left")) + oWhalf;
			var oy = parseInt($(obj).css("top")) + oHhalf;
			
			var rang = 10;
			//alert("321");
			
			var left = true;
			var top = true;
			var right = true;
			var bottom = true;
			
			//左右檢測
			//碰撞者由中心往左右算起
			if(!$(this).is(obj))
			{
				//alert("312");
				
				if((ox + oWhalf  > x && ox - oWhalf  < x + thisW) && (oy + oHhalf > y && oy - oHhalf < y + thisH))
				{
					if((oy + oHhalf > y && oy < y + thisH ) )
					{
						$(obj).css({
							'top' : y - thisH - 10
						})
					}
					
					if((oy - oHhalf < y + thisH && oy > y) )
					{
						$(obj).css({
							'top' : y + thisH + 10
						})
					}
					
					
				}
			}
	})
}

function addPointObj() {
	
	$(".canvas").append(
		"<div class='drag point' style='left:" + ((parseInt($(document).width() * 0.5) - parseInt($(".canvas").css("left"))) - ($(".drag").width() * 0.5)) + "px;top: " + ((parseInt($(document).height() * 0.5) - parseInt($(".canvas").css("top"))) - ($(".drag").height() * 0.5)) + "px' onclick='pointClick(this)'  pid='" + pointObjIndex + "'><div class='pointBorder'></div><div class='pointBorderShadow'></div><div class='pointTextBox'><div class='pointTextDesc' style='position: relative;'></div></div>"
	)
	
	$(".drag").bind("mousedown", mouseDown);
	$(".drag").bind("mouseup", mouseUp);
	
	
	pointObjIndex++;
}

function displayUpPos() {
	displayDownPos();
	
	$(".point").each(function() {
		
		var ch_lid = $(this).attr("ch_lid");
		var lid = $(this).attr("lid");
		
		if((ch_lid != undefined && ch_lid != "" ) && (lid != undefined && lid != "" ) )
		{
					
			var line_ch_lid_ary = ch_lid.split(",");
			
			for(var i = 0; i < line_ch_lid_ary.length; i++)
			{
				
				var line = $(".line[ch_lid=" + line_ch_lid_ary[i] + "]");
				//隱藏line
				$(line).css({
					'display' : 'none'
				})
			}
			
		}
		
		if((ch_lid != undefined && ch_lid != "" ) && (lid == undefined || lid == "" ) )
		{
					
			var line_ch_lid_ary = ch_lid.split(",");
			
			for(var i = 0; i < line_ch_lid_ary.length; i++)
			{
				
				var line = $(".line[ch_lid=" + line_ch_lid_ary[i] + "]");
				//隱藏line
				$(line).animate({
					'opacity' : '0'
				},function() {
					$(this).css({
						'display' : 'none'
					})
				})
			}
			
			//隱藏point
			$(this).animate({
				'opacity' : '0'
			},function() {
				$(this).css({
					'display' : 'none'
				})
			})
			
		}
		
		
	})
} 

function displayDownPos() {
	
	$(".point").css({
		'display' : 'block',
		'opacity' : '1',
		'width' : '80px',
		'height' : '80px'
	})
	
	$(".point").find(".pointBorder").css({
		'display' : 'block',
		'opacity' : '1',
		'width' : '100px',
		'height' : '100px'
	})
	
	$(".point").find(".pointBorderShadow").css({
		'display' : 'block',
		'opacity' : '1',
		'width' : '100px',
		'height' : '100px'
	})
	
	
	/*
	$(".line").css({
		'display' : 'block',
		'opacity' : '1'
	})*/
	
	
	$(".point").each(function() {
		//setline
		var p = $(this);
		var lid = $(this).attr("lid");
		var ch_lid = $(this).attr("ch_lid");
		
		
		if(lid != undefined && lid != "")
		{
			var lid_ary = lid.split(",");
			for(var i = 0; i < lid_ary.length; i++){
				
				var line = $(".line[lid=" + lid_ary[i] + "]");
				setLine(lid_ary[i], $(line).attr("cid"), $(line).attr("tid"));
		
			}
		}
		
		if(ch_lid != undefined && ch_lid != "")
		{
			var ch_lid_ary = ch_lid.split(",");
			for(var i = 0; i < ch_lid_ary.length; i++){
				
				
				var line = $(".line[ch_lid=" + ch_lid_ary[i] + "]");
				setChildLine(ch_lid_ary[i], $(line).attr("cid"), $(line).attr("tid"));
			}
		}
		
				
		if($(this).css("display") == 'none')
		{
			$(this).css({
				'display' : 'block'
				
			})
			$(this).animate({
				'opacity' : '1'
			})
		}
	})
		
	$(".line").each(function() {
		if($(this).css("display") == 'none')
		{
			$(this).css({
				'display' : 'block'
			})
			$(this).animate({
				'opacity' : '1'
			})
		}
	})
}

//只顯示該節點下位
function getThisPointGroup() {
	$(".point").css({
		'display' : 'none'
	})
	$(".line").css({
		'display' : 'none'
		
	})
	
	var p = pointClickObj;
	
	
	$(p).css({
		'display' : 'block',
		'opacity' : '1',
		'width' : '120px',
		'height' : '120px'
	})
	
	$(p).find(".pointBorder").css({
		'display' : 'block',
		'opacity' : '1',
		'width' : '140px',
		'height' : '140px'
	})
	
	$(p).find(".pointBorderShadow").css({
		'display' : 'block',
		'opacity' : '1',
		'width' : '140px',
		'height' : '140px'
	})
	
	if($(p).attr("ch_lid") != undefined && $(p).attr("ch_lid") != "")
	{
		var ary = $(p).attr("ch_lid").split(",");
		
		//alert(ary)	;
		//尋找場上的POINT是否也有與自己相同的CH_LID
		for(var i = 0; i < ary.length; i++)
		{
			$(".point").each(function() {
				if($(this).attr("ch_lid") != undefined && $(this).attr("ch_lid") != "" && $(this).attr("pid") != $(p).attr("pid"))
				{
					var p_ary = $(this).attr("ch_lid").split(",");
				
					for(var j = 0; j < p_ary.length; j++)
					{
						if(p_ary[j] == ary[i])
						{
							$(this).css({
								'display' : 'block',
								'opacity' : '1'
							})
							
							//alert($(p).attr("pid") + " " + $(this).attr("pid"));
							
							setChildLine(p_ary[j], $(p).attr("pid"), $(this).attr("pid"));
						}
						
						//set ch_line
							//alert(p_ary[j] + " " + $(p).attr("pid") + " " + $(this).attr("pid"));
							
					}
					
					
				}
				
			})
			
			//顯示該點有連到的CH)LID
			$(".line[ch_lid=" + ary[i] + "]").css({
				'display' : 'block',
				'opacity' : '1'
			})
			
		}
	}
	
}



/**
 * save to json 
 */

function encodeJson() {
	var ary = new Array();
	
	$(".canvas").find("div").each(function() {
		var obj = new Object();
		
		if($(this).hasClass("line") && $(this).hasClass("chLine") )
		{
			
				obj.type = "chLine";
				obj.ch_lid = isEmpty($(this).attr("ch_lid"));
				obj.cid = isEmpty($(this).attr("cid"));
				obj.tid = isEmpty($(this).attr("tid"));
				obj.width = isEmpty($(this).width());
				obj.deg = isEmpty($(this).attr("deg"));
				obj.x = parseInt($(this).css("left"));
				obj.y = parseInt($(this).css("top"));		
				ary.push(obj);
			
		}
		else if($(this).hasClass("line") )
		{
			
				obj.type = "line";
				obj.lid = isEmpty($(this).attr("lid"));
				obj.cid = isEmpty($(this).attr("cid"));
				obj.tid = isEmpty($(this).attr("tid"));
				obj.width = isEmpty($(this).width());
				obj.deg = isEmpty($(this).attr("deg"));
				obj.x = parseInt($(this).css("left"));
				obj.y = parseInt($(this).css("top"));		
				ary.push(obj);
			
			
		}
		else if($(this).hasClass("point"))
		{
			
				obj.type = "point";
				obj.pid = isEmpty($(this).attr("pid"));
				obj.lid = isEmpty($(this).attr("lid"));
				obj.ch_lid = isEmpty($(this).attr("ch_lid"));
				obj.text = isEmpty($(this).text());
				obj.x = parseInt($(this).css("left"));
				obj.y = parseInt($(this).css("top"));		
				ary.push(obj);
			
		}
		
		
		
	})
		
	var json = JSON.stringify(ary, null, 2);
	
	//alert(json);
	
	test_json = json;
	
	//alert(test_json);
	
	/*
	var href = window.location.href;
	
		$.post(
			href + "/addNode",
			{
				data : test_json
			},
			function(data) {
				alert("complete: " + data);
			}
		).fail(function(data) {
			alert(data);
		})*/
	
	//test progress	
	$.ajax({
		xhr: function()
			{
				var xhr = new window.XMLHttpRequest();
				//Upload progress
				xhr.upload.addEventListener("progress", function(evt){
				if (evt.lengthComputable) {
				var percentComplete = evt.loaded / evt.total;
			      //Do something with upload progress
				//console.log(percentComplete);
				//alert(percentComplete);
				$(".ajaxProressBox").css({
			     	'display' : 'block'
			     })
			    $(".ajaxProressBg").width(percentComplete * 200);
				$(".ajaxProressText").text(percentComplete * 100);
			}
		}, false);
		 //Download progress
		xhr.addEventListener("progress", function(evt){
			if (evt.lengthComputable) {
				var percentComplete = evt.loaded / evt.total;
			     //Do something with download progress
			    //alert(percentComplete);
			    $(".ajaxProressBox").css({
			     	'display' : 'block'
			     })
			    $(".ajaxProressBg").width(percentComplete * 200);
				$(".ajaxProressText").text(percentComplete * 100);
			}
		}, false);
		     return xhr;
		   },
		   type: 'POST',
		   url: href + "/addNode",
		   data: {
				data : test_json
		   },
		   success: function(data){
		     //Do something success-ish
		     //alert("123 complete xhr: " + data);
		     $(".ajaxProressBg").width(0);
		     $(".ajaxProressBox").css({
		     	'display' : 'none'
		     })
		   }
	 });
}

function isEmpty(str) {
	if(str == undefined || str == "")
	{
		return "";
	}
	else
	{
		return str;
	}
}

/**
 * read for json 
 */

function decodeJson() {
	//clear sence
	var json = "";
	var href = window.location.href;
	
	$.ajax({
		xhr: function()
			{
				var xhr = new window.XMLHttpRequest();
				//Upload progress
				xhr.upload.addEventListener("progress", function(evt){
				if (evt.lengthComputable) {
				var percentComplete = evt.loaded / evt.total;
			      //Do something with upload progress
				//console.log(percentComplete);
				//alert(percentComplete);
				$(".ajaxProressBox").css({
			     	'display' : 'block'
			     })
			    $(".ajaxProressBg").width(percentComplete * 200);
				$(".ajaxProressText").text(percentComplete * 100);
			}
		}, false);
		 //Download progress
		xhr.addEventListener("progress", function(evt){
			if (evt.lengthComputable) {
				var percentComplete = evt.loaded / evt.total;
			     //Do something with download progress
			    //alert(percentComplete);
			    $(".ajaxProressBox").css({
			     	'display' : 'block'
			     })
			    $(".ajaxProressBg").width(percentComplete * 200);
				$(".ajaxProressText").text(percentComplete * 100);
			}
		}, false);
			return xhr;
			},
			type: 'POST',
			url: href + "/readNode",
			data: {
				
			},
			success: function(data){
		     //Do something success-ish
		     //alert("123 complete xhr: " + data);
		     $(".ajaxProressBg").width(0);
		     $(".ajaxProressBox").css({
		     	'display' : 'none'
			})
			
			$(".canvas").html("");
			//隱藏存檔
			$(".saveBtn").css({
				'display' : 'none'
			})
	
			json = data;
			
			var json = JSON.parse(json);
	
			for(var i = 0; i < json.length;i++)
			{
				if(json[i].type == "line")
				{
					readLine(
						json[i].x,
						json[i].y,
						json[i].lid,
						json[i].node_from,
						json[i].node_to,
						json[i].width,
						json[i].z
					)
					lineIndex = parseInt(json[i].lid) + 1;
					tmpLineIndex = parseInt(json[i].lid);
					
				}
				else if(json[i].type == "chLine")
				{
					readChildLine(
						json[i].x,
						json[i].y,
						json[i].lid,
						json[i].node_from,
						json[i].node_to,
						json[i].width,
						json[i].z
					)
					
					lineIndex = parseInt(json[i].lid) + 1;
					tmpLineIndex = parseInt(json[i].lid);
				}
				else if(json[i].type == "point")
				{
					readPoint(
						json[i].x,
						json[i].y,
						json[i].pid,
						json[i].lid,
						json[i].ch_lid,
						json[i].name,
						json[i].uuid,
						json[i].lock
					)
					
					pointObjIndex = parseInt(json[i].pid) + 1;
					tmpPointIndex = parseInt(json[i].pid);
					
				}
			}
		     
		}
	 });
	
	/*
	$.post(
		href + "/readNode",
		function(data) {
			
		}
	)
		*/
}

function encodeUpdJson() {
	//displayDownPos();
	
	var ary = new Array();
	
	$(".canvas").find("div").each(function() {
		var obj = new Object();
		
		if($(this).hasClass("line") && $(this).hasClass("chLine") )
		{
			
				obj.type = "chLine";
				obj.ch_lid = isEmpty($(this).attr("ch_lid"));
				obj.cid = isEmpty($(this).attr("cid"));
				obj.tid = isEmpty($(this).attr("tid"));
				obj.width = isEmpty($(this).width());
				obj.deg = isEmpty($(this).attr("deg"));
				obj.x = parseInt($(this).css("left"));
				obj.y = parseInt($(this).css("top"));		
				ary.push(obj);
			
		}
		else if($(this).hasClass("line") )
		{
			
				obj.type = "line";
				obj.lid = isEmpty($(this).attr("lid"));
				obj.cid = isEmpty($(this).attr("cid"));
				obj.tid = isEmpty($(this).attr("tid"));
				obj.width = isEmpty($(this).width());
				obj.deg = isEmpty($(this).attr("deg"));
				obj.x = parseInt($(this).css("left"));
				obj.y = parseInt($(this).css("top"));		
				ary.push(obj);
			
			
		}
		else if($(this).hasClass("point"))
		{
			
				obj.type = "point";
				obj.pid = isEmpty($(this).attr("pid"));
				obj.lid = isEmpty($(this).attr("lid"));
				obj.ch_lid = isEmpty($(this).attr("ch_lid"));
				obj.text = isEmpty($(this).text());
				obj.x = parseInt($(this).css("left"));
				obj.y = parseInt($(this).css("top"));		
				ary.push(obj);
			
		}
		
		
		
	})
		
	var json = JSON.stringify(ary, null, 2);
	
	//alert(json);
	
	test_json = json;
	
	//alert(test_json);
	
	
	var href = window.location.href;
	/*
		$.post(
			href + "/updNode",
			{
				data : test_json
			},
			function(data) {
				alert("complete: " + data);
			}
		).fail(function(data) {
			//alert(data);
		})*/
		
	$.ajax({
		xhr: function()
			{
				var xhr = new window.XMLHttpRequest();
				//Upload progress
				xhr.upload.addEventListener("progress", function(evt){
				if (evt.lengthComputable) {
				var percentComplete = evt.loaded / evt.total;
			      //Do something with upload progress
				//console.log(percentComplete);
				//alert(percentComplete);
				$(".ajaxProressBox").css({
			     	'display' : 'block'
			     })
			    $(".ajaxProressBg").width(percentComplete * 200);
				$(".ajaxProressText").text(percentComplete * 100);
			}
		}, false);
		 //Download progress
		xhr.addEventListener("progress", function(evt){
			if (evt.lengthComputable) {
				var percentComplete = evt.loaded / evt.total;
			     //Do something with download progress
			    //alert(percentComplete);
			    $(".ajaxProressBox").css({
			     	'display' : 'block'
			     })
			    $(".ajaxProressBg").width(percentComplete * 200);
				$(".ajaxProressText").text(percentComplete * 100);
			}
		}, false);
		     return xhr;
		   },
		   type: 'POST',
		   url: href + "/updNode",
		   data: {
				data : test_json
		   },
		   success: function(data){
		     //Do something success-ish
		     //alert("123 complete xhr: " + data);
		     $(".ajaxProressBg").width(0);
		     $(".ajaxProressBox").css({
		     	'display' : 'none'
		     })
		   }
	 });
}

function removePointPost(obj) {
	var href = window.location.href;
	var p_obj = new Object();
	p_obj.type = "point";
	p_obj.pid = isEmpty($(obj).attr("pid"));
	p_obj.lid = isEmpty($(obj).attr("lid"));
	p_obj.ch_lid = isEmpty($(obj).attr("ch_lid"));
	p_obj.text = isEmpty($(obj).text());
	p_obj.x = parseInt($(obj).css("left"));
	p_obj.y = parseInt($(obj).css("top"));	
	var j = JSON.stringify(p_obj, null,2);
	
	
	
	/*
	$.post(
		href + "/delNode",
		{
			data : j
		},
		function(data) {
			
		}
	)*/
	
	$.ajax({
		xhr: function()
			{
				var xhr = new window.XMLHttpRequest();
				//Upload progress
				xhr.upload.addEventListener("progress", function(evt){
				if (evt.lengthComputable) {
				var percentComplete = evt.loaded / evt.total;
			      //Do something with upload progress
				//console.log(percentComplete);
				//alert(percentComplete);
				$(".ajaxProressBox").css({
			     	'display' : 'block'
			     })
			    $(".ajaxProressBg").width(percentComplete * 200);
				$(".ajaxProressText").text(percentComplete * 100);
			}
		}, false);
		 //Download progress
		xhr.addEventListener("progress", function(evt){
			if (evt.lengthComputable) {
				var percentComplete = evt.loaded / evt.total;
			     //Do something with download progress
			    //alert(percentComplete);
			    $(".ajaxProressBox").css({
			     	'display' : 'block'
			     })
			    $(".ajaxProressBg").width(percentComplete * 200);
				$(".ajaxProressText").text(percentComplete * 100);
			}
		}, false);
		     return xhr;
		   },
		   type: 'POST',
		   url: href + "/delNode",
		   data: {
				data : j
		   },
		   success: function(data){
		     //Do something success-ish
		     //alert("123 complete xhr: " + data);
		     encodeUpdJson();
		     $(".ajaxProressBg").width(0);
		     $(".ajaxProressBox").css({
		     	'display' : 'none'
		     })
		   }
	 });
}

function removeLinkPost(_obj) {
	
	var href = window.location.href;
	var obj = new Object();
	obj.type = "line";
	obj.lid = isEmpty($(_obj).attr("lid"));
	obj.cid = isEmpty($(_obj).attr("cid"));
	obj.tid = isEmpty($(_obj).attr("tid"));
	obj.width = isEmpty($(_obj).width());
	obj.deg = isEmpty($(_obj).attr("deg"));
	obj.x = parseInt($(_obj).css("left"));
	obj.y = parseInt($(_obj).css("top"));		
	var j = JSON.stringify(obj, null,2);
	
	$.ajax({
		xhr: function()
			{
				var xhr = new window.XMLHttpRequest();
				//Upload progress
				xhr.upload.addEventListener("progress", function(evt){
				if (evt.lengthComputable) {
				var percentComplete = evt.loaded / evt.total;
			      //Do something with upload progress
				//console.log(percentComplete);
				//alert(percentComplete);
				$(".ajaxProressBox").css({
			     	'display' : 'block'
			     })
			    $(".ajaxProressBg").width(percentComplete * 200);
				$(".ajaxProressText").text(percentComplete * 100);
			}
		}, false);
		 //Download progress
		xhr.addEventListener("progress", function(evt){
			if (evt.lengthComputable) {
				var percentComplete = evt.loaded / evt.total;
			     //Do something with download progress
			    //alert(percentComplete);
			    $(".ajaxProressBox").css({
			     	'display' : 'block'
			     })
			    $(".ajaxProressBg").width(percentComplete * 200);
				$(".ajaxProressText").text(percentComplete * 100);
			}
		}, false);
		     return xhr;
		   },
		   type: 'POST',
		   url: href + "/delLink",
		   data: {
				data : j
		   },
		   success: function(data){
		     //Do something success-ish
		     //alert("123 complete xhr: " + data);
		     $(".ajaxProressBg").width(0);
		     $(".ajaxProressBox").css({
		     	'display' : 'none'
		     })
		   }
	 });
	
	/*
	$.post(
		href + "/delLink",
		{
			data : j
		},
		function(data) {
			alert("remove: " + data);
		}
	)*/
}

function removeLinkChildPost(_obj) {
	
	var href = window.location.href;
	var obj = new Object();
	obj.type = "chLine";
	obj.ch_lid = isEmpty($(_obj).attr("ch_lid"));
	obj.cid = isEmpty($(_obj).attr("cid"));
	obj.tid = isEmpty($(_obj).attr("tid"));
	obj.width = isEmpty($(_obj).width());
	obj.deg = isEmpty($(_obj).attr("deg"));
	obj.x = parseInt($(_obj).css("left"));
	obj.y = parseInt($(_obj).css("top"));		
	var j = JSON.stringify(obj, null,2);
	
	$.ajax({
		xhr: function()
			{
				var xhr = new window.XMLHttpRequest();
				//Upload progress
				xhr.upload.addEventListener("progress", function(evt){
				if (evt.lengthComputable) {
				var percentComplete = evt.loaded / evt.total;
			      //Do something with upload progress
				//console.log(percentComplete);
				//alert(percentComplete);
				$(".ajaxProressBox").css({
			     	'display' : 'block'
			     })
			    $(".ajaxProressBg").width(percentComplete * 200);
				$(".ajaxProressText").text(percentComplete * 100);
			}
		}, false);
		 //Download progress
		xhr.addEventListener("progress", function(evt){
			if (evt.lengthComputable) {
				var percentComplete = evt.loaded / evt.total;
			     //Do something with download progress
			    //alert(percentComplete);
			    $(".ajaxProressBox").css({
			     	'display' : 'block'
			     })
			    $(".ajaxProressBg").width(percentComplete * 200);
				$(".ajaxProressText").text(percentComplete * 100);
			}
		}, false);
		     return xhr;
		   },
		   type: 'POST',
		   url: href + "/delLink",
		   data: {
				data : j
		   },
		   success: function(data){
		     //Do something success-ish
		     //alert("123 complete xhr: " + data);
		     $(".ajaxProressBg").width(0);
		     $(".ajaxProressBox").css({
		     	'display' : 'none'
		     })
		   }
	 });
	
	/*
	$.post(
		href + "/delLink",
		{
			data : j
		},
		function(data) {
			alert("child: " + data);
		}
	)*/
}



/**
 * read for json point data
 *  
 * @param {Object} x
 * @param {Object} y
 * @param {Object} pid
 * @param {Object} lid
 * @param {Object} ch_lid
 */
function readPoint(x, y, pid, lid, ch_lid, text, uuid, lock) {
	var lid_attr = "";
	var ch_lid_attr = "";
	if(lid != undefined && lid != "" )
	{
		lid_attr = "lid='" + lid + "'"; 
	}
	if(ch_lid != undefined && ch_lid != "" )
	{
		ch_lid_attr = "ch_lid='" + ch_lid + "'"; 
	}
	
	$(".canvas").append(
		"<div class='drag point " + lock + "' uuid=" + uuid + " style='left:" + x + "px;top: " + y + "px;background-color:#fff' onclick='pointClick(this)'  pid='" + pid + "' " + lid_attr + " " + ch_lid_attr + "><div class='pointBorder'></div><div class='pointBorderShadow'></div><div class='pointTextBox'><div class='pointTextDesc' style='position: relative;'>" + text + "</div></div></div>"
	)
	
	$(".drag").bind("mousedown", mouseDown);
	$(".drag").bind("mouseup", mouseUp);
}

function readLine(x, y ,lid ,cid ,tid,width,deg)
{
	
	$(".canvas").append(
		"<div class='line' style='width:" + width + "px;left:" + x + "px;top:" + y + "px;' lid='" + lid + "' cid='" + cid + "' tid='" + tid + "' deg='" + deg + "'></div>"
	);
	
	var line = $(".line[lid=" + lid +"]");
	
	$(line).css({
		'transform': 'rotate(' + deg + 'deg)'
	})
		
}

function readChildLine(x, y ,ch_lid ,cid ,tid,width,deg)
{
	
	$(".canvas").append(
		"<div class='line chLine' style='width:" + width + "px;left:" + x + "px;top:" + y + "px;' ch_lid='" + ch_lid + "' cid='" + cid + "' tid='" + tid + "' deg='" + deg + "'></div>"
	);
	
	var line = $(".line[ch_lid=" + ch_lid +"]");
	
	$(line).css({
		'transform': 'rotate(' + deg + 'deg)'
	})
		
}




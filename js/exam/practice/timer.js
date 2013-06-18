/**
 * @author Shown
 */
var _min=0,_sec=0;

$(document).ready(function(){
	$("div#timer").append("");
	timedCount(_sec);
});

function timedCount(_sec)
{	
	if(_sec==60)
	{
		_sec=0;
		_min++;	
	}
	$("div#timer div.min").html(checkNum(_min));
	$("div#timer div.sec").html(checkNum(_sec));
	
	_sec++;
	setTimeout(function(){timedCount(_sec)},1000);
	
}

function checkNum(_num)
{
	if(_num<10)
	{
		return "0"+_num;
	}
	else
	{
		return _num;
	}
}
/*
function start()
{
	var _sec=parseInt($("div#limitTime div.limitSec").html());
	if(_sec==0)
	{
		_sec=60;
	}
	else
	{
		_sec--;
	}	
	$("div#limitTime div.limitSec").html(_sec);
	start();
}

function cutSec()
{
	
}
*/
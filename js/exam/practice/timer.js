/**
 * @author Shown
 */
var _min,_sec;
var _limitMin,_limitSec;


$(document).ready(function(){
	
});

function timedCount()
{	
	
	
	$("div#timer div.min").html(checkNum(_min));
	$("div#timer div.sec").html(checkNum(_sec));
	if(_sec==60)
	{
		_sec=0;
		_min++;	
	}	
	
	_sec++;
	setTimeout(function(){timedCount()},1000);
	
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

function start()
{
	
	$("div#limitTime div.limitMin").html(checkNum(_limitMin));
	$("div#limitTime div.limitSec").html(checkNum(_limitSec));
	
	if(_limitSec==0)
	{
		if(_limitMin==0)
		{
			$("span#sentOutAns").click();
		}else{
			_limitSec=60;
			_limitMin--;
		}	
	}
	else
	{
		if(_limitSec<=30 && _limitMin==0)
		{
			$("div#limitTime div.limitSec").css("color","red");
		}
	}
	
	_limitSec--;
	setTimeout(function(){start()},1000);
	
	
}


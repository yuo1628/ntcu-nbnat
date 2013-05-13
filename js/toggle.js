/**
 * @author Shown
 */

$(document).ready(function() {
	var toggle = "close";
	$("#toggle").click(function() {
		if (toggle == "close") {
			toggle = "open";
			$("#menu").animate({
				width : "4%"
			}, 500, function() {
				$("#menu ul li a span span").hide();
			});
			$("#toggle div").animate({
					borderSpacing : 180
				}, {
					step : function(now, fx) {
						$(this).css('-webkit-transform', 'rotate(' + now + 'deg)');
						$(this).css('-moz-transform', 'rotate(' + now + 'deg)');
						$(this).css('-ms-transform', 'rotate(' + now + 'deg)');
						$(this).css('-o-transform', 'rotate(' + now + 'deg)');
						$(this).css('transform', 'rotate(' + now + 'deg)');					},
					duration : 'slow'
				}, 'linear');
			$("#main").animate({
				width : "90%"
			}, 500);

			$(this).animate({
				width : "18px"
			});

		} else {
			toggle = "close";
			$("#menu").animate({
				width : "22%"
			}, 500);
			$("#main").animate({
				width : "72%"
			}, 500);
			$("#toggle div").animate({
					borderSpacing : 0
				}, {
					step : function(now, fx) {
						$(this).css('-webkit-transform', 'rotate(' + now + 'deg)');
						$(this).css('-moz-transform', 'rotate(' + now + 'deg)');
						$(this).css('-ms-transform', 'rotate(' + now + 'deg)');
						$(this).css('-o-transform', 'rotate(' + now + 'deg)');
						$(this).css('transform', 'rotate(' + now + 'deg)');
					},
					duration : 'slow'
				}, 'linear');
			$("#menu ul li a span span").show();

			$(this).css({
				width : "25px",
				"padding-left" : "0"
			}).animate({
				height : "105%"
			});
		}
	});

});

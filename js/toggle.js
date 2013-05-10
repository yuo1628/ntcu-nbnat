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
			$("#main").animate({
				width : "90%"
			},500);
			
			$(this).animate({
				width : "18px"
			}).html("<div>></div>");

		} else {
			toggle = "close";
			$("#menu").animate({
				width : "22%"
			});
			$("#main").animate({
				width : "72%"
			});
			$("#menu ul li a span span").show();
			$(this).css({
				width : "25px",
				"padding-left" : "0"
			}).animate({
				height : "105%"
			}).html("<div><</div>");
		}
	});

});

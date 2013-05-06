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
			});
			$("#menu ul li a span").hide("slow");
			$("#main").animate({
				width : "90%"
			});
			$(this).animate({
				width : "18px"
			}).html("");
		} else {
			toggle = "close";
			$("#menu").animate({
				width : "22%"
			});
			$("#main").animate({
				width : "72%"
			});
			$("#menu ul li a span").show("slow");
			$(this).css({
				width : "25px",
				"padding-left" : "0"
			}).animate({
				height : "105%"
			}).html("");
		}
	});

});

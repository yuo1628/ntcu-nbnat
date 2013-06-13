/**
 * @author Shown
 */
$(document).ready(function() {
	

});

function slide(_id, _state) {
	switch (_state) {
		case "close":
			var _href = location.href;
			$.ajax({
				url : _href + "/findChild/" + _id,
				cache : false,
				dataType : "html",
				success : function(result) {
					$("ul#node li#li-" + _id).after("<li>" + result + "</li>");

				}
			});
			$("ul#node li#li-" + _id).removeClass().addClass("open");

			$("ul#node li#li-" + _id).attr("onclick", "slide('" + _id + "','open')");

			break;
		case "open":
			$("ul#node li#li-" + _id).next("li").remove();
			$("ul#node li#li-" + _id).attr("onclick", "slide('" + _id + "','close')");
			$("ul#node li#li-" + _id).removeClass().addClass("nodeList");
			break;
	}

}

function enter(_id) {
	var _href = location.href;

	$.post(_href + "/findExamList", {
		uid : _id
	}, function(data) {
		$("div#practice").html(data);
	});

}



/**
 * @author Shown
 */
$(document).ready(function() {
	$("#node_to").hide();
});
function meta(_id) {
	var _name = $("#li-" + _id + " div span").html();
	$("#li-" + _id + " div").hide();

	var _href = location.href;
	$.ajax({
		url : _href + "/nodeTemplate/" + _id,
		cache : false,
		dataType : "html",
		success : function(result) {

			$("#li-" + _id).append(result);
			$("#li-" + _id + " select.nodeList option[value=" + _id + "]").remove();
			$("#n_nameText-" + _id).val(_name);
			$("#li-" + _id + " select.nodeToList option").each(function() {
				var _val = $(this).val();
				$("#li-" + _id + " select.nodeList option").each(function() {
					if ($(this).val() == _val) {
						$(this).remove();
					}

				});
			});

			$("#childItemList-" + _id + " div.childItem div").each(function() {
				var _this = $(this);
				var c_id = $(this).attr("id").replace("child-", "");

				$.ajax({
					url : _href + "/findRote/" + c_id,
					cache : false,
					dataType : "html",
					success : function(result) {
						_this.after(result);
					}
				});

			});

		}
	});

}

function addNode() {
	var _href = location.href;
	var _value = $("#n_name").val();

	$.post(_href + "/addNode", {
		value : _value
	}, function() {
		location.href = "./index.php/node";
	});

}

function delNode(_id) {
	var _href = location.href;
	$.ajax({
		url : _href + "/delNode/" + _id
	}).done(function() {
		location.href = "./index.php/node";
		//$("#child-"+_id).remove();
	});
}

function meta_close(_id) {
	$("#li-" + _id + " div:eq(0)").show();
	$("#li-" + _id + " #div-" + _id).remove();
}

function addLink(_from) {
	var _href = location.href;
	var _to = $("#div-" + _from + " select.nodeList option:selected").val();

	$.ajax({
		url : _href + "/addLink/" + _from + "/" + _to
	}).done(function() {
		location.href = "./index.php/node";
	});

}

function delLink(_from) {
	var _href = location.href;
	var _to = $("#nodeToList-" + _from + " select.nodeToList option:selected").val();
	
	
	$.post(_href + "/delLink", {
		from : _from,to :_to
	}, function() {
		location.href = "./index.php/node";
	});
}

function updNode(_id) {
	var _href = location.href;
	var _value = $("#n_nameText-" + _id).val();

	$.post(_href + "/updNode/" + _id, {
		value : _value
	}, function() {
		location.href = "./index.php/node";
	});

}

function addChild(_id) {
	var _href = location.href;
	var _value = $("#c_nameText-" + _id).val();
	var _to = $("#childList-" + _id + " option:selected").val();

	$(".site").each(function() {
		if ($(this).prop("checked")) {
			switch ($(this).val()) {
				case "alone":

					$.post(_href + "/addNode/2/" + _id, {
						value : _value
					}, function() {
						location.href = "./index.php/node";
					});

					break;
				case "after":

					$.post(_href + "/addNodeAndLink/" + _id + "/" + _to, {
						value : _value
					}, function() {
						location.href = "./index.php/node";
					});

					break;

			}

		}
	});

}

function childEdit(id, child_id) {
	var grade = $("#child-" + child_id).attr("class");
	if (grade == "master") {
		$("#childEditTemp-" + id).html("<input type='text' id='n_nameText-"+child_id+"' value='"+ $("#child-" + child_id).html()+"' /><span onclick=\"updNode('" + child_id + "')\" >修改</span><span onclick=\"delAfterRote('"+ child_id + "')\" >移除後關聯</span>");
	} else {
		$("#childEditTemp-" + id).html("<input type='text' id='n_nameText-"+child_id+"' value='"+ $("#child-" + child_id).html()+"' /><span onclick=\"updNode('" + child_id + "')\" >修改</span><span onclick=\"delNode('" + child_id + "')\" >刪除</span><span onclick=\"delBeforeRote('"+ child_id + "')\" >移除前關聯</span><span onclick=\"delAfterRote('"+ child_id + "')\" >移除後關聯</span>");

	}

}

function delAfterRote(_id)
{
	var _href = location.href;
	$.post(_href + "/delLink", {
		to :_id
	}, function() {
		location.href = "./index.php/node";
	});
}
function delBeforeRote(_id)
{
	var _href = location.href;
	$.post(_href + "/delLink", {
		from :_id
	}, function() {
		location.href = "./index.php/node";
	});
}

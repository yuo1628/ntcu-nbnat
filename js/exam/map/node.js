/**
 * @author Shown
 */
$(document).ready(function() {
	$("#node_to").hide();
});
function meta(_id) {
	var _name = $("#li-" + _id + " div span").html();
	$("#li-" + _id + " div").hide();
	$("#li-" + _id).append("<div id='div-" + _id + "'><span onclick=\"delNode('" + _id + "')\">刪除</span><br/><h6>指標名稱：</h6><input type='text' id='n_nameText-" + _id + "' value='" + _name + "' /><span onclick=\"updNode('" + _id + "')\">更改</span><br/><div id='nodeToList-" + _id + "'><span onclick=\"delLink('" + _id + "')\">刪除</span></div>" + $("#node_to").html() + "<span onclick=\"addLink('" + _id + "')\">新增</span><br/><h6>建立主細目：</h6><input type='text' id='node_first-"+_id+"' /><br/><span onclick=\"meta_close('" + _id + "')\" >取消</span></div>");
	$("#li-" + _id + " select.nodeList option[value=" + _id + "]").remove();

	var _href = location.href;
	$.ajax({
		url : _href + "/findLinkTo/" + _id,
		cache : false,
		dataType : "html",
		success : function(result) {

			$("#nodeToList-" + _id).prepend(result);

		}
	});
}

function addNode() {
	var _href = location.href;
	var _value = $("#n_name").val();
	$.ajax({
		url : _href + "/addNode/" + _value
	}).done(function() {
		location.href = "./index.php/node";
	});
}

function delNode(_id) {
	var _href = location.href;
	$.ajax({
		url : _href + "/delNode/" + _id
	}).done(function() {
		location.href = "./index.php/node";
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

	$.ajax({
		url : _href + "/delLink/" + _from + "/" + _to
	}).done(function() {
		location.href = "./index.php/node";
	});

}

function updNode(_id) {
	var _href = location.href;
	var _value = $("#n_nameText-" + _id).val();

	$.ajax({
		url : _href + "/updNode/" + _id + "/" + _value
	}).done(function() {
		location.href = "./index.php/node";
	});

}

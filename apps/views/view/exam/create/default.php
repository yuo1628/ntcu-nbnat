<div id="create">
	<h1>管理試題</h1>
	<ul>
		<li>
			<h5>請選擇指標：</h5>
			<select id="node">
				<?php foreach ($result as $item):	?>
				<?php echo "<option value='" . $item -> id . "'>" . $item -> name . "</option>"; ?>
				<?php endforeach; ?>
			</select>
		</li>
	</ul>
	<div id='tools'>
		<ul>
			<ul><li class='action unabled' onclick='batchDel()'>刪除</li></ul>
			<ul><li class='action unabled' onclick="batchShow('close')">展開</li><li class='action unabled' onclick="batchShow('open')">收合</li></ul>
			<ul><li class='action unabled' onclick="batchPublic('open')">開放</li><li class='action unabled' onclick="batchPublic('close')">不開放</li></ul>
			<ul><li class='actionScore unabled'>修改配分</li><li class='actionScore'><input type="text" id="batchScoreText" disabled="disabled"></input></li><li class='action unabled' onclick="batchScore()">更改</li></ul>
		</ul>
	</div>
	<div></div>
	<div id="quizList"></div>
	<span class="greenBtn" onclick="showTemp()">新增試題</span>
	<div style="display:none;" id="template">
		<h5>選擇類型</h5>
		<select id="type">
			<option selected="selected" value="0">請選擇...</option>
			<option value="choose">單選題</option>
			<option value="multi_choose">多選題</option>					
		</select>
		<div id="content"></div>
	</div>
	<div id="qList"></div>
	
</div>

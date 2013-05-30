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
	<span class="greenBtn" onclick="showTemp()">新增試題</span>
	<div style="display:none;" id="template">
		<h5>選擇類型</h5>
		<select id="type">
			<option selected="selected">請選擇...</option>
			<option value="choose">單選題</option>
			<option value="multiChoose">多選題</option>
			<option value="fill">填充題</option>			
		</select>
		<div id="content"></div>
	</div>
	<div id="qList"></div>
	
</div>

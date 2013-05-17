<div id="node">
	<h1>指標管理</h1>
	<br/>
	<br/>
		<ul id="create">
			<li>
				<h5>請輸入指標名稱</h5>
				<div>			
					<input type="text" class="textStyle" id="n_name" />	
					<a onclick="addNode()" class="greenBtn">建立	</a>	
				</div>
			</li>
		</ul>
	
	<br/>
	<ul id="nodeList">
		<?php foreach ($result as $item):?>
		<?php echo "<li id='li-".$item -> id."'><div onclick=\"meta('".$item -> id."')\">(" .$item -> id.")<span>". $item -> name . "</span></div></li>"; ?>
		<?php endforeach; ?>
	</ul>

</div>
<div id="node_to">
	<h6>增加上位：</h6>
	<select class="nodeList">
	<?php foreach ($result as $item):?>
		<?php echo "<option value='".$item -> id."'>". $item -> name . "</option>"; ?>
	<?php endforeach; ?>
	</select>
</div>
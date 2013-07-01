<div id="node">
	<h1>指標管理</h1>
	<br/>
	<br/>
		<ul id="create">
			<li>
				<h5>請輸入指標名稱</h5>
				<div>			
					<input type="text" class="textStyle" id="n_name" />	
					<a onclick="addNode()" class="greenBtn">建立</a>	
				</div>
			</li>
		</ul>
	
	<br/>
	<ul id="nodeList">
		<?php foreach ($result as $item):?>
		<?php echo "<li id='li-".$item -> id."'><div class='cursor' onclick=\"meta('".$item -> id."')\">(" .$item -> id.")<span>". $item -> name . "</span></div></li>"; ?>
		<?php endforeach; ?>
	</ul>

</div>

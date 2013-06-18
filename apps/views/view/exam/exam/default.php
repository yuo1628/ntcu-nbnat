<div id="practice">
	<h1>管理試卷</h1>
	
	<ul id="node">
		<?php foreach ($result as $item):
		?>
		<?php echo "<li id='li-".$item -> id."' class='nodeList' onclick=\"slide('".$item -> id."','close')\" >" . $item -> name . "</li>"; ?>
		<?php endforeach; ?>
	</ul>
	
</div>


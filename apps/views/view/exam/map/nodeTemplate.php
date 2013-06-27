
<?php echo "<div id='div-" . $id . "'>"; ?>
<?php echo "<span onclick=\"delNode('$id')\">刪除</span>"; ?>
<br/>
<h6>指標名稱：</h6>
<?php echo "<input type='text' id='n_nameText-$id' />"; ?>
<?php echo "<span onclick=\"updNode('$id')\">更改</span>"; ?>
<br/>
<h6>指標上位：</h6>
<select class="nodeToList">
	<?php foreach ($node_to as $item):
	?>
	<?php echo "<option value='" . $item -> node_to . "'>" . $item -> name . "</option>"; ?>
	<?php endforeach; ?>
</select><?php echo "<span onclick=\"delLink('$id')\">刪除</span>"; ?>
<br/>
<h6>增加上位：</h6>
<select class="nodeList">
	<?php foreach ($result as $item):
	?>
	<?php echo "<option value='" . $item -> id . "'>" . $item -> name . "</option>"; ?>
	<?php endforeach; ?>
</select>
	<?php echo "<span onclick=\"addLink('$id')\">新增</span>"; ?>
<br/>
<h6>指標細目：</h6>
		<?php echo "<input class='site' type='radio' name='site-$id' value='alone' checked='checked'/>"; ?>獨
立
		<?php echo "<input class='site' type='radio' name='site-$id' value='after' />"; ?>在
		<?php echo "<select id='childList-$id'>"; ?>
	<?php foreach ($childFirst as $item):?>
		<?php echo "<option value='" . $item -> id . "'>" . $item -> name . "</option>"; ?>
	<?php endforeach; ?>
	<?php foreach ($childList as $item):?>
		<?php echo "<option value='" . $item -> id . "'>" . $item -> name . "</option>"; ?>
	<?php endforeach; ?>
</select>之後

<?php echo "<input type='text' id='c_nameText-$id' />"; ?>
<?php echo "<span onclick=\"addChild('$id')\" >建立</span>"; ?>
<br/>
<?php echo "<div id='childItemList-$id'>"; ?>
<?php foreach ($childFirst as $item): ?>
<?php echo "<div class='childItem'><div class='master' id='child-" . $item -> id . "' onclick=\"childEdit('$id','".$item -> id."')\">" . $item -> name . "</div></div>"; ?>
<?php endforeach; ?>

<?php foreach ($childRote as $item): ?>
<?php echo "<div class='childItem'><div class='child' id='child-" . $item -> id . "' onclick=\"childEdit('$id','".$item -> id."')\">" . $item -> name . "</div></div>"; ?>
<?php endforeach; ?>
</div>
<?php echo "<div class='actTool' id=\"childEditTemp-$id\">"; ?>
	
</div>
<hr/>
<?php echo "<span onclick=\"meta_close('$id')\" >取消</span>"; ?>
</div>

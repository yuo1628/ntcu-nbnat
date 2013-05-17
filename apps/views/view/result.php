
<h6>指標上位：</h6>
<select class="nodeToList">
<?php foreach ($result as $item):?>
<?php echo "<option value='".$item -> node_to."'>". $item -> node_to . "</option>"; ?>
<?php endforeach; ?>
</select>
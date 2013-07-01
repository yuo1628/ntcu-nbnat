<select id="child">
	<?php foreach ($childList as $item):
	?>
	<?php echo "<option value='" . $item -> uuid . "'>" . $item -> name . "</option>"; ?>
	<?php endforeach; ?>
</select>
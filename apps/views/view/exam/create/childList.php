<select id="child">
	<?php foreach ($childList as $item):
	?>
	<?php echo "<option value='" . $item -> id . "'>" . $item -> name . "</option>"; ?>
	<?php endforeach; ?>
</select>
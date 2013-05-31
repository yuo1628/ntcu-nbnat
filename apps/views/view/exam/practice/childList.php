<ul id="childList">
	<?php foreach ($childList as $item):

	?>
	<?php echo "<li>" . $item -> name;
		if ($item -> count > 0) {
			echo "<span class='blueBtn' onclick=\"enter('" . $item -> id . "')\">進行測驗</span>";
		}
		echo "</li>";
	?>
	<?php endforeach; ?>
</ul>
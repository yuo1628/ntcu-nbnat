<ul id="childList">
	<?php foreach ($childList as $item):

	?>
	<?php echo "<li>" . $item -> name."<div class='btn'>";
		if ($item -> open_answer=="open" && $item -> count_e > 0) {
			echo "<span class='greenBtn' onclick=\"enter('" . $item -> uuid . "')\">進行測驗</span>";
			
		}
		if ($item -> count_a > 0) {
			echo "<span class='blueBtn' onclick=\"result('" . $item -> uuid . "')\">進入查看</span>";
		}
		echo "</div></li>";
	?>
	<?php endforeach; ?>
</ul>
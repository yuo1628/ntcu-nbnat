<div id="practice">
	<h1>線上測驗</h1>
		
	<ul id="childList">
	<?php foreach ($childList as $item):

	?>
	<?php echo "<li>" . $item -> name."<span class='quizMeta'>題數：". $item ->count_e."</span><span class='quizMeta'>總分：".$item ->count_score."</span><div class='btn'>";
		 ?>
		 
			<?php 
		if ($item -> open_answer=="open" && $item -> count_e > 0) {
				if (count($item->isFinish )>0)
				{				
					echo "<span class='greenBtn' onclick=\"continuePractice('". $item -> uuid . "','". $item->isFinish[0]->id . "')\">續考</span>";
					echo "<span class='grayBtn' onclick=\"reStart('" . $item -> uuid . "')\" >進行測驗</span>";
				}				
				else
				{
					echo "<span class='greenBtn' onclick=\"enter('" . $item -> uuid . "')\">進行測驗</span>";
				}
				
			
		}
		if ($item -> count_a > 0) {
			echo "<span class='blueBtn' onclick=\"result('" . $item -> uuid . "')\">進入查看</span>";
		}
		echo "</div></li>";
	?>
	<?php endforeach; ?>
</ul>
</div>

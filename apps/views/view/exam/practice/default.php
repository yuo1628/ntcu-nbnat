<div id="practice">
	<h1>線上測驗</h1>
		
	<ul id="childList">
	<?php foreach ($childList as $item):

	?>
	<?php echo "<li><h2>" . $item -> name."</h2><span class='quizMeta'>題數：". $item ->count_e."</span><span class='quizMeta'>總分：".$item ->count_score."</span><div class='btn'>";
		 ?>
		 
			<?php 
		if ($item -> open_answer=="open" && $item -> count_e > 0) {
				if (count($item->isNotFinish )>0)
				{
								
					echo "<span class='greenBtn' uuid='" . $item -> uuid .  "' onclick=\"continuePractice('". $item -> uuid . "','". $item->isNotFinish[0]->id . "','".count(json_decode($item->isNotFinish[0]->answer))."')\">續考</span>";
					echo "<span class='grayBtn' onclick=\"reStart('" . $item -> uuid . "')\" >進行測驗</span>";
				}				
				else
				{
					echo "<span class='greenBtn' uuid='" . $item -> uuid .  "' onclick=\"enter('" . $item -> uuid . "')\">進行測驗</span>";
				}			
		}
		if ($item -> count_a > 0 ) 
		{
		
			echo "<span class='blueBtn' onclick=\"result('" . $item -> uuid . "')\">進入查看</span>";
		}
		echo "</div></li>";
	?>
	<?php endforeach; ?>
</ul>
</div>

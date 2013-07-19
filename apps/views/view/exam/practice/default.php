<div id="practice">
	<h1>線上測驗</h1>
	<div id="kmMes">
		<ul>
			<li>
				<h6>年級：</h6>
				<?php if($kmGrade<=6): ?>
				<?php echo "國小 ".($kmGrade)." 年級" ?>
				<?php elseif($kmGrade>6 && $kmGrade<=9): ?>
				<?php echo "國中 ".($kmGrade-6)." 年級" ?>
				<?php elseif($kmGrade>9 && $kmGrade<=12): ?>
				<?php echo "高中 ".($kmGrade-9)." 年級" ?>
				<?php elseif($kmGrade>13 && $kmGrade<=17): ?>
			    <?php echo "大學 ".($kmGrade-9)." 年級" ?>
				<?php endif; ?>
			</li>
			<li>
				<h6>建立者：</h6>
				<?php echo($tName); ?>
			</li>
			<li>
				<h6>科目：</h6>
				<?php echo($kmSub); ?>
			</li>
		</ul>
	</div>
	<ul id="childList">
	<?php foreach ($childList as $item):

	?>
	<?php echo "<li><h2>" . $item -> name."</h2><span class='quizMeta'>題數：". $item ->count_e."</span><span class='quizMeta'>總分：".$item ->count_score."</span><div class='btn'>";
		 ?>

			<?php
		if ($item -> open_answer=="open" && $item -> count_e > 0) {

				if (isset($item->ansId))
				{
					echo "<span class='greenBtn' uuid='" . $item -> uuid .  "' onclick=\"continuePractice('". $item -> uuid . "','". $item->ansId . "','".$item->isNotFinish."')\">續考</span>";
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

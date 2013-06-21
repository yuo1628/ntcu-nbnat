<div id="practice">
	<h1>管理試卷</h1>
	
	<ul id="childList">
	<?php foreach ($childList as $item):?>
	<li id="li-<?= $item -> uuid; ?>">
	<div class="lockState">
		<div id="lock-<?= $item -> uuid; ?>" class="<?php echo $item -> lock; ?>" onclick="lockToggle('<?= $item -> uuid; ?>')"></div>
	</div>

	<div class="quiz">
	<h3><?php echo $item -> name; ?></h3>
		<div class="state">
			<span>總題數：<?php echo $item -> count_total; ?></span>
			<span>開放題數：<?php echo $item -> count_open; ?></span>
			<span>總得分：<?php echo $item -> count_score; ?></span><br/>
			<span class="openState">開放狀態：		
				<?php if($item -> open_answer=="close"):	?>
				<?php echo "<span class='fontRed'>不開放作答</span>"; ?>	
				<?php else:?>	
				<?php echo "<span class='fontGreen'>開放作答</span>"; ?>	
				限制時間：<span class="fontBlue">
					<?php if($item -> limit_time!="0"): ?>
						<?php echo floor($item -> limit_time/60)." 分 ". ($item -> limit_time%60)." 秒" ; ?>
					<?php else:?>	
						<?php echo "無限期"; ?>
					<?php endif;?>
					</span>
				<?php endif;?>	
			</span>				
			<div class="btn">
				<?php if($item -> lock=="unlock"):	?>				
				<?php echo "<span class='unlockBtn blueBtn' onclick=\"quizManage('".$item -> uuid."')\">管理試題</span>"; ?>	
				
				<?php else:?>
				<?php echo "<span class='unlockBtn blueBtn' style='display:none;' onclick=\"quizManage('".$item -> uuid."')\">管理試題</span>"; ?>					
				<?php endif;?>
					<?php if($item -> open_answer=="close"):	?>
						<?php if($item -> count_open>0):	?>
							<?php echo "<span class='openBtn blueBtn' onclick=\"openToggle('".$item -> uuid."','open')\">開放作答</span>"; ?>	
						<?php else:?>
							<?php echo "<span class='openBtn unabledBtn' title='必須設定開放試題，才能開放此試卷作答'>開放作答</span>"; ?>	
						<?php endif;?>	
						
					<?php else:?>	
					<?php echo "<span class='closeBtn grayBtn' onclick=\"openToggle('".$item -> uuid."','close')\">取消開放</span>"; ?>	
					<?php endif;?>	
			</div>
		</div>
	</div>
	</li>
	<?php endforeach; ?>
</ul>
</div>
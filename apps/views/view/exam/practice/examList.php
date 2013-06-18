<div id="examTitle">
<h1><?php echo $examTitle[0]->name;?></h1>
	<?php if($examTitle[0]->limit_time>0):?>	
		<div id="limitTime" style="display:none;">
			<div class="limitMin">
				<?php if(floor($examTitle[0]->limit_time/60)<10):?>
					<?php echo "0".floor($examTitle[0]->limit_time/60);?>
				<?php else:?>
					<?php echo floor($examTitle[0]->limit_time/60);?>
				<?php endif;?>
			</div>
			<div class="point">：</div>
			<div class="limitSec">				
				<?php if(floor($examTitle[0]->limit_time%60)<10):?>
					<?php echo "0".floor($examTitle[0]->limit_time%60);?>
				<?php else:?>
					<?php echo floor($examTitle[0]->limit_time%60);?>
				<?php endif;?>
			</div>		
		</div>
	<?php endif;?>
	
	<div id="timer">
		<div class="min">00</div>
		<div class="point">：</div>
		<div class="sec">00</div>
	</div>
</div>
<ul id="examList">
	<?php foreach ($examList as $j=>$item):
	?>
	<?php echo "<li class='topicLi' id='li-".$item->id."'>"; ?>	
		
		
		<?php echo "<div class='topic'>".($j+1).".".$item -> topic."</div>"; ?>
		
		<?php echo "<ul>"; ?>
		<?php switch ($item -> type) : 
			case 'choose': 
			?>			
				<?php foreach($item->optionList as $i => $optionItem):?>
										
					<?php echo "<li><input type='radio' name='item-".$item->id."' value='".$optionItem->id."' />"; ?>
					
					<?php echo chr ( 0x41+$i).". ".$optionItem->value."</li>"; ?>
					
				<?php endforeach; ?>
				<?php break; ?>
			<?php case 'multi_choose': ?>
				<?php foreach($item->optionList as $i =>$optionItem):?>
					
					<?php echo "<li><input type='checkbox' value='".$optionItem->id."' />"; ?>
					
					<?php echo chr ( 0x41+$i).". ".$optionItem->value."</li>"; ?>
				<?php endforeach; ?>
				<?php break; ?>
		<?php endswitch; ?>
	<?php echo "</ul>"; ?>
	
	<?php echo "<div class='tipsBtn' id='tipsBtn-".$item->id."'>"; ?>
	
		<?php if(count(json_decode($item->tips,true))>0):?>			
			<?php echo "<span class='tips' onclick=\"showTips('".$item->id."','close')\">提示</span>"; ?>
		<?php endif;?>
		<?php echo "</div>"; ?>	
	
	<?php echo "</li>"; ?>
	<?php endforeach; ?>
</ul>
<p id="examBtn">
	<span class="previousQuiz" onclick="previousQuiz()">上一題</span>
	<span class="nextQuiz" onclick="nextQuiz()">下一題</span>
	<span class="blueBtn" onclick="save('<?php echo $examTitle[0]->uuid ?>')">離開並記錄作答位置</span>
	<span class="greenBtn" onclick="send('<?php echo $examTitle[0]->uuid ?>')">繳交試卷</span>
</p>
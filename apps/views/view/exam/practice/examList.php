
<div class="navMenu">
	<?php 
	$display = 'block';
	foreach($examList as $i => $item): 
	?>
	<?php if($i != 0){
		$display = 'none';
	}
	?>
	<div class="mediaBtn navItem" style="display: <?php echo $display; ?>" onclick="showMedia('<?php echo $item->media_url; ?>')">
		觀看教學影片
	</div>
		
	<?php endforeach; ?>
	
	<a href="./index.php/map">
		<div class="navItem">
			回到知識結構
		</div>
	</a>
	<div class="clearfix"></div>
</div>
<div class="examBox">
	<div id="examTitle">
	<h1><?php echo $examTitle[0]->name;?></h1>
	<div id="openState" style="display:none;"><?php echo $examTitle[0]->open_answer;?></div>
	<div id="examMeta">
		<div id="quizNum"><div>題數：</div><span class="quizOn"></span>&nbsp;/&nbsp;<?php echo count($examList); ?></div>
			
			<div id="timer">
				<div>花費時間：</div>
				<?php if(isset($lastAns[0])): ?>				
					<div class="min"><?php echo (floor($lastAns[0]->spend/60)<10) ? "0".floor($lastAns[0]->spend/60):floor($lastAns[0]->spend/60); ?></div>
					<div class="point">:</div>
					<div class="sec"><?php echo (($lastAns[0]->spend%60)<10) ? "0".($lastAns[0]->spend%60) : ($lastAns[0]->spend%60); ?></div>
				<?php else: ?>
					<div class="min">00</div>
					<div class="point">:</div>
					<div class="sec">00</div>
				<?php endif; ?>
			</div>
			<?php if($examTitle[0]->limit_time>0):?>	
				<div id="limitTime" class="fontBlue">
					<div>剩餘時間：</div>
					<div class="limitMin">
						<?php if(floor($examTitle[0]->limit_time/60)<10):?>
							<?php echo "0".floor($examTitle[0]->limit_time/60);?>
						<?php else:?>
							<?php echo floor($examTitle[0]->limit_time/60);?>
						<?php endif;?>
					</div>
					<div class="point">:</div>
					<div class="limitSec">				
						<?php if(floor($examTitle[0]->limit_time%60)<10):?>
							<?php echo "0".floor($examTitle[0]->limit_time%60);?>
						<?php else:?>
							<?php echo floor($examTitle[0]->limit_time%60);?>
						<?php endif;?>
					</div>		
				</div>
			<?php endif;?>
		</div>
	</div>
	
	<ul id="examList">
		
		<?php foreach ($examList as $j=>$item):
		?>
		
		<?php echo "<li class='topicLi' id='li-".$item->id."'> "; ?>	
			<div class="quizType"><?php echo $item -> type; ?></div>
			
			<?php if(!empty($item -> ansValue)): ?>
            <div class="ansValue"><?php echo json_encode($item -> ansValue); ?></div>
            
            <?php endif;?>
			<?php echo "<div class='topic'>".($j+1).".".$item -> topic."</div>"; ?>
			
			<?php echo "<ul>"; ?>
			<?php switch ($item -> type) : 
				case 'choose': 
				?>			
					<?php foreach($item->optionList as $i => $optionItem):?>
						<?php echo "<li><input type='radio' name='item-".$item->id."' value='".$optionItem->id."'";
						if(isset($optionItem->checked))
						{
							echo "checked='checked'";
						}
						echo " />"; ?>
						
						<?php echo chr ( 0x41+$i).". ".$optionItem->value."</li>"; ?>
						
					<?php endforeach; ?>
					<?php break; ?>
				<?php case 'multi_choose': ?>
					<?php foreach($item->optionList as $i =>$optionItem):?>
						
						<?php echo "<li><input type='checkbox' value='".$optionItem->id."'";
						if(isset($optionItem->checked))
						{
							echo "checked='checked'";
						}
						echo "/>"; ?>
						
						<?php echo chr ( 0x41+$i).". ".$optionItem->value."</li>"; ?>
					<?php endforeach; ?>
					<?php break; ?>				
			<?php endswitch; ?>
		<?php echo "</ul>"; ?>
		
		<?php echo "<div class='tipsBtn' id='tipsBtn-".$item->id."'>"; ?>
		
			<?php if(count(json_decode($item->tips,true))>0):?>			
				<?php echo "<span class='tips' onclick=\"showTips('".$item->id."','close')\">提示</span>"; ?>
			<?php endif;?>
			<?php if($item->media_url!=""&&$item->media_url!=null&&$item->media_url!="0"): /*?>			
				<?php echo "<span class='media' media='" .$item->media_url. "' onclick=\"showMedia('".$item->media_url."')\">教學影片</span>"; ?>
			<?php */ endif;?>
			<?php echo "</div>"; ?>	
		
		<?php echo "</li>"; ?>
		<?php endforeach; ?>
	</ul>
	<p id="examBtn">
		<span class="previousQuiz" onclick="previousQuiz()">上一題</span>
		<span class="nextQuiz" onclick="nextQuiz()">下一題</span>
		<?php if($examTitle[0]->limit_time==0):?>	
		<span class="blueBtn" onclick="finish('<?php echo $examTitle[0]->uuid ?>',false,'<?php echo (isset($lastAns[0])) ? "update','".$lastAns[0]->id : "add" ?>')">離開並記錄作答位置</span>
		<?php endif; ?>	
		<span id="sentOutAns" class="greenBtn" onclick="finish('<?php echo $examTitle[0]->uuid ?>',true,'<?php echo (isset($lastAns[0])) ? "update','".$lastAns[0]->id : "add" ?>')">繳交試卷</span>
	</p>

<div class="clearfix"></div>
</div>
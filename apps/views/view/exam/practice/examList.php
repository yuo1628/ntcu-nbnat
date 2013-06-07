<h1><?php echo $examTitle[0]->name;?></h1>
<ul id="examList">
	<?php foreach ($examList as $j=>$item):
	?>
	<?php echo "<li class='topicLi' id='li-".$item->id."'>"; ?>	
		
		
		<?php echo "<div class='topic'>".($j+1).".".$item -> topic."</div>"; ?>
		<?php echo "<div class='tipsBtn' id='tipsBtn-".$item->id."'>"; ?>
	
		<?php if($item->tips!=""):?>			
			<?php echo "<span class='tips' onclick=\"showTips('".$item->id."','".$item->tips."','close')\">提示</span>"; ?>
		<?php endif;?>
		<?php echo "</div>"; ?>	
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
	<?php echo "</ul></li>"; ?>
	<?php endforeach; ?>
</ul>
<p style="text-align: center;">
<?php echo "<span class=\"greenBtn\" onclick=\"send('".$examTitle[0]->uuid."')\">送出</span>"; ?>
</p>
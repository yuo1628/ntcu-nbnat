<h1><?php echo $examTitle[0]->name;?></h1>
<ul id="examList">
	<?php foreach ($examList as $item):
	?>
	<?php echo "<li class='topic'>"; ?>	
		
		<?php echo $item -> topic."<ul>"; ?>
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

<?php echo "<span class=\"greenBtn\" onclick=\"send('".$examTitle[0]->id."')\">送出</span>"; ?>
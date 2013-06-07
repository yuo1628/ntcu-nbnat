<div id='editTemplate'>
	<input type="text" value="<?php echo $quiz[0] -> topic;?>" id="edit_topicText" /></div>


<?php echo "<div class='tipsMes'><p>提示：</p>"; ?>	
<?php echo "<textarea id='tipsTextarea'>".$quiz[0]->tips."</textarea>"; ?>
<?php echo "</div>"; ?>

	<ul id="editOption">
		<?php switch ($quiz[0] -> type) : 
			case 'choose': 
			?>			
				<?php foreach($quiz[0]->optionList as $i => $optionItem):?>
										
					<?php echo "<li class='oldOption'><input type='radio' name='item-".$quiz[0]->id."' value='".$optionItem->id."'";
							if ($optionItem->correct=="true")
							{
								 echo "checked='checked'";
							}						
					 echo "/>"; ?>
					
					<?php echo chr ( 0x41+$i).". <textarea class='option' id='option-".$optionItem->id."'>".$optionItem->value."</textarea></li>"; ?>
					
				<?php endforeach; ?>
				<?php break; ?>
			<?php case 'multi_choose': ?>
				<?php foreach($quiz[0]->optionList as $i =>$optionItem):?>
					
					<?php echo "<li class='oldOption'><input type='checkbox' value='".$optionItem->id."'";
						 	if ($optionItem->correct=="true")
							{
								 echo "checked='checked'";
							}						
					 echo "/>"; ?>
					
					<?php echo chr ( 0x41+$i).". <textarea class='option' id='option-".$optionItem->id."'>".$optionItem->value."</textarea></li>"; ?>
				<?php endforeach; ?>
				<?php break; ?>
		<?php endswitch; ?>		
	</ul>
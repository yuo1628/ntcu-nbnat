<div class='editTemplate'>
	<textarea class="edit_topicText"><?php echo $quiz[0] -> topic;?></textarea>


<?php echo "<div class='tipsMes'><p>提示：</p>"; ?>	
<?php echo "<textarea class='tipsTextarea'>".$quiz[0]->tips."</textarea>"; ?>
<?php echo "</div>"; ?>

	<ul id="editOption-<?php echo $quiz[0] -> id;?>">
		<?php switch ($quiz[0] -> type) : 
			case 'choose': 
			?>			
				<?php foreach($quiz[0]->optionList as $i => $optionItem):?>
										
					<?php echo "<li class='oldOption' id='oldOption-".$optionItem->id."'><input type='radio' name='item-".$quiz[0]->id."' value='".$optionItem->id."'";
							if ($optionItem->correct=="true")
							{
								 echo "checked='checked'";
							}						
					 echo "/><textarea class='option' id='option-".$optionItem->id."'>".$optionItem->value."</textarea><span class='delBtn' onclick=\"removeOption('".$optionItem->id."')\">X</span></li>"?>
				<?php endforeach; ?>
				<?php break; ?>
			<?php case 'multi_choose': ?>
				<?php foreach($quiz[0]->optionList as $i =>$optionItem):?>
					
					<?php echo "<li class='oldOption' id='oldOption-".$optionItem->id."'><input type='checkbox' value='".$optionItem->id."'";
						 	if ($optionItem->correct=="true")
							{
								 echo "checked='checked'";
							}						
					 echo "/><textarea class='option' id='option-".$optionItem->id."'>".$optionItem->value."</textarea><span class='delBtn' onclick=\"removeOption('".$optionItem->id."')\">X</span></li>"?>
									<?php echo "</li>"?>
				<?php endforeach; ?>
				<?php break; ?>
		<?php endswitch; ?>				
	</ul>
	<span class="newOption" onclick="newOption('<?php echo ($quiz[0] -> id);?>','<?php echo ($quiz[0] -> type);?>')">新增選項</span>
</div>
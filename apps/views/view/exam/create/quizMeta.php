<?php if($quiz[0]->tips!="") echo "<div class='tipsMes'><p>提示：</p>".$quiz[0]->tips."</div>"; ?>
	<?php echo "<ul>"; ?>
		<?php switch ($quiz[0] -> type) : 
			case 'choose': 
			?>			
				<?php foreach($quiz[0]->optionList as $i => $optionItem):?>
										
					<?php echo "<li><input type='radio' name='item-".$quiz[0]->id."' value='".$optionItem->id."' disabled='disabled'";
							if ($optionItem->correct=="true")
							{
								 echo "checked='checked'";
							}						
					 echo "/>"; ?>
					
					<?php echo chr ( 0x41+$i).". ".$optionItem->value."</li>"; ?>
					
				<?php endforeach; ?>
				<?php break; ?>
			<?php case 'multi_choose': ?>
				<?php foreach($quiz[0]->optionList as $i =>$optionItem):?>
					
					<?php echo "<li><input type='checkbox' value='".$optionItem->id."' disabled='disabled'";
						 	if ($optionItem->correct=="true")
							{
								 echo "checked='checked'";
							}						
					 echo "/>"; ?>
					
					<?php echo chr ( 0x41+$i).". ".$optionItem->value."</li>"; ?>
				<?php endforeach; ?>
				<?php break; ?>
		<?php endswitch; ?>
	<?php echo "</ul>";	?>

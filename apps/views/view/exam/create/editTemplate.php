<div class='editTemplate'>
	<textarea class="edit_topicText"><?php echo $quiz[0] -> topic;?></textarea>
<?php $tipsArray=json_decode($quiz[0]->tips,true);

	echo "<div class='tipsMes' id='tips-".$quiz[0] -> id."'><p>提示：<span onclick=\"tipsAppend('".$quiz[0] -> id."')\">新增提示</span></p>";
for($i=0;$i<count($tipsArray);$i++)
{
	echo "<div id='tipsDiv-".$i."' class='tipsDiv'>";
	echo "<span class='tipsTopic'>Step ".($i+1)."</span>";	
	echo "<textarea class='tipsTextarea'>".$tipsArray[$i]."</textarea>";
	echo "<span class='delBtn' onclick=\"removeTips('".$i."','".$quiz[0] -> id."')\">X</span>";
	echo "</div>";
}		
echo "</div>";

?>

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
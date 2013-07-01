<table id="examList" cellspacing="0">
	
	<?php echo "<tr><th width='50px'><input type='checkbox' class='all' onclick='checkAll()' /></th><th width='50px'>題號</th><th>題目</th><th width='50px'></th><th width='50px'>配分</th><th width='50px'>狀態</th></tr>"; ?>
	<?php if(count($examList)>0):?>
	<?php foreach ($examList as $j=>$item):	?>
	
	<?php echo "<tr class='topicLi' id='topicLi-".$item->id."'><td><input type='checkbox' class='quiz'  onclick='decideCheck()' value='exam-".$item->id."' /></td><td class='number'></td><td>"; ?>
	<?php echo "<div class='topicDiv' id='div-".$item->id."'>"; ?>	
				
		<?php echo "<div class='topic'>".$item -> topic."</div>"; ?>
		
		
		 <?php echo "</div>";?>
	<?php echo "</td><td><span class='show' onclick=\"showOption('".$item->id."','close')\">展開</span></td><td class='score'><span class='fontBlue'>".(($item -> score)/100)."</span></td><td class='public'>";
			if($item -> public=="true")
			{
				echo "<span class='fontGreen'>開放</span>";
			}
			else
			{
				echo "<span class='fontRed'>不開放</span>";
			}
	echo "</td></tr>"; ?>
	<?php endforeach; ?>
	<?php else:?>
	<?php echo "<tr><td class='empty' colspan='6'>尚未新增試題</td></tr>"; ?>	
	<?php endif;?>	
</table>

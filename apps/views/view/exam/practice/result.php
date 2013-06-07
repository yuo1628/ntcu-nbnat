<div id="result">
	<h1>測驗結果</h1>
	<div style="display:none;" id="uuid"><?php echo $uuid;?></div>
	<div id="head">
		<table cellspacing="0">
			<tr>
				<th>測驗次別：</th><td>第
				<select id="times">
					<?php foreach ($result as $i=>$item):
					?>
					<?php echo "<option value='" . $item -> id . "'"; ?>
					<?php if($item->id==$userAns[0]->id):
					?>
					<?php echo "selected='selected'"; ?>
					<?php endif; ?>
					<?php echo ">" . ($i + 1) . "</option>"; ?>
					<?php endforeach; ?>
				</select>次答題 </td>
			</tr>
			<tr><th>測驗時間：</th><td><span id="time"><?php echo $userAns[0] -> time; ?></span></td></tr>
			<tr><th>測驗資訊：</th><td class="topic">花費時間﹦<span id="spend"><?php echo $userAns[0] -> spend; ?></span></td></tr>
			<tr><th></th><td class="topic">測驗題數﹦<span id="count"><?php echo $count; ?></span></td></tr>
			<tr><th></th><td class="topic">答對題數﹦<span id="correct"><?php 					
					if(in_array("1",$correct))
					{
						$show=array_count_values($correct);
						echo $show["1"];
					}
					else
					{
						echo "0";
					}					
				?></span></td></tr>
			<tr><th></th><td class="topic">測驗得分﹦<span id="score"><?php echo $score; ?></span></td></tr>
		</table>
	</div>
	 	
	<ul id="examList">
	<?php foreach ($quizAns as $i=>$item):?>
		<?php echo "<li class='topicLi'>"; ?>
		
		<?php echo "<span class='score'>得分：<span>"; ?>
		<?php if($correct[$i]=="1"){echo $item["score"];}else{echo "0";} ?>
		<?php echo "</span>分</span><br/>" ;?>
				
		<?php echo "<div class='topic'>".($i+1) .". ".$item["topic"]."</div>";?>
			<ul>
				
			<?php foreach ($item["ans"] as $j=>$option):?>	
				<?php 
				if($correct[$i]=="0" && $option["correct"]=="true")
				{ 
					echo "<li class='green'>"; 
				}
				else
				{
					echo "<li>"; 	
				}
				?>
				<?php switch ($item["type"]) {
					case 'choose':											
						echo "<input type='radio' name='option-".$item["topicId"]."' disabled='disabled' ";
						if (in_array($option["id"], $userOptionAns[$i]))
						{
							 echo "checked='checked'";
						}					
						echo "></input>";		
									
						break;
					case 'multi_choose':
						echo "<input type='checkbox' name='option-".$item["topicId"]."' disabled='disabled' ";
						if (in_array($option["id"], $userOptionAns[$i]))
						{
							 echo "checked='checked'";
						}					
						echo "></input>";	
						break;					
				}
				?>	
				<?php echo chr ( 0x41+$j).".".$option["value"]."</li>";?>
			<?php endforeach; ?>
			</ul>
		<?php echo "</li>";?>	
	<?php endforeach; ?>
	</ul>

</div>

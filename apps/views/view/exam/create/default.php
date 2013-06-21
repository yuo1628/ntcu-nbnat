<div id="create">
	<h1 id="nodeTitle">管理試題</h1>
			
		
	
	<div id='tools'>
		<ul>
			<ul><li class='action unabled' onclick='batchDel()'>刪除</li></ul>
			<ul><li class='action unabled' onclick="batchShow('close')">展開</li><li class='action unabled' onclick="batchShow('open')">收合</li></ul>
			<ul><li class='action unabled' onclick="batchPublic('open')">開放</li><li class='action unabled' onclick="batchPublic('close')">不開放</li></ul>
			<ul><li class='actionScore unabled'>修改配分</li><li class='actionScore'><input type="text" id="batchScoreText" disabled="disabled"></input></li><li class='action unabled' onclick="batchScore()">更改</li></ul>
		</ul>
		<div><span></span></div>
	</div>
	
	<div id="quizList"><table id="examList" cellspacing="0">
	
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
</div>
	<span class="greenBtn" onclick="showTemp()">新增試題</span>
	<div style="display:none;" id="template">
		<h5>選擇類型</h5>
		<select id="type">
			<option selected="selected" value="0">請選擇...</option>
			<option value="choose">單選題</option>
			<option value="multi_choose">多選題</option>					
		</select>
		<div id="content"></div>
	</div>
	<div id="qList"></div>
	
</div>

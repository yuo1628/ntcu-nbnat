<table id="topic" cellspacing="0">
	<tr>
		<th>配分</th><td><input type="text" id="scoreText" value="0" /><input type="checkbox" id="show" checked="checked" />開放給學生作答</td>
	</tr>	
	<tr>
		<th>題目</th><td colspan="2"><textarea id="topicText"></textarea></td>
	</tr>
	<tr>
		<th>提示</th><td colspan="2"><span onclick="addtips()" class="addtips">新增提示</span></td>
	</tr>
	<tr class="tipsTemp">
		<th><?php echo "Step 1";?></th><td colspan="2"><textarea class="tipsText"></textarea></td>
	</tr>
</table>

<table id="choose" cellspacing="0">
	<thead>
		<tr>
			<th>答案</th><th>選項內容</th><th></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th>
			<input type="radio" name="answer" />
			</th>
			<td>
				<textarea class="answerText"></textarea>
			</td>
			
		</tr>
	</tbody>
</table>
<p id="btnTools">
	<span class="blueBtn" onclick="addoption()">新增選項</span>
	<span class="greenBtn" onclick="sendOut()">完成並送出</span>
	<span class="grayBtn" onclick="cancel()">取消</span>
</p>


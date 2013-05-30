<!-- css & js-->
<?php
//include head
echo $this -> layout -> fetchHead();
?>

<table id="topic" cellspacing="0">
	<tr>
		<th>題目</th><td><textarea id="topicText"></textarea></td>
	</tr>
	<tr>
		<th>提示</th><td>	<textarea id="tipsText"></textarea></td>
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
			</th><td><textarea class="answerText"></textarea></td>
		</tr>
	</tbody>
</table>
<p id="btnTools">
	<span class="blueBtn" onclick="addoption()">新增選項</span>
	<span class="greenBtn" onclick="sendOut()">完成並送出</span>
	<span class="grayBtn" onclick="cancel()">取消</span>
</p>


<div id="map_default">
	<h1>知識結構列表</h1>
	<br /><br />
	
	<input type="checkbox" value="subject" />
	<h2>科目</h2>
	<select id="subjectSelect">	
	<?php if(count($sunjectList)>0): ?>
		
		<?php foreach ($sunjectList as $value): ?>
			<option value="<?php echo $value->id; ?>"><?php echo $value->subject; ?></option>
		<?php endforeach; ?>			
	<?php else: ?>
		<option value="0">尚無科目資料</option>
	<?php endif; ?>
	</select>	
	<input type="checkbox" value="teacher"/>
	<h2>老師</h2>
	<select id="teacherSelect">	
	<?php if(count($teacherList)>0): ?>		
		<?php foreach ($teacherList as $value): ?>
			<option value="<?php echo $value->id; ?>"><?php echo $value->name; ?></option>
		<?php endforeach; ?>		
	<?php else: ?>
		<option value="0">尚無老師資料</option>
	<?php endif; ?>
	</select>		
	<span class="blueBtn" onclick="kmList()">送出查詢</span>
	<div id="kmList"></div>
</div>


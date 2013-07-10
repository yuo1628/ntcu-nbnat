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
	<input type="checkbox" value="grade"/>
	<h2>年級</h2>		
	<select id="gradeSelect">	
		<?php foreach ($gradeList as $value): ?>
			<option value="<?php echo $value->grade; ?>">
			<?php if($value->grade<=6): ?>
			<?php echo "國小 ".($value->grade)." 年級" ?>	
			<?php elseif($value->grade>6 && $value->grade<=9): ?>
			<?php echo "國中 ".($value->grade-6)." 年級" ?>	
			<?php elseif($value->grade>9 && $value->grade<=12): ?>
			<?php echo "高中 ".($value->grade-9)." 年級" ?>				
			<?php endif;?>
			</option>
		<?php endforeach; ?>
	</select>		
	<span class="blueBtn" onclick="kmList()">送出查詢</span>
	<div id="kmList">
		
	</div>
</div>


<div id="map_manage">
	<h1>管理知識結構</h1>
	<br /><br />	
	<h5>科目：</h5>
	
	<?php if(count($sunjectList)>0): ?>
		<select id="subjectSelect">	
		<?php foreach ($sunjectList as $value): ?>
			<option value="<?php echo $value->id; ?>"><?php echo $value->subject; ?></option>
		<?php endforeach;?>
		</select>	
		<span class="fontGray" id="subTextToggle">建立科目</span>	
	<?php else: ?>
		<input type="text" id="subText"></input>
	<?php endif; ?>		
	<h5>學制：</h5>
	<select id="typeSelect">		
		<option value="0">國小</option>
		<option value="6">國中</option>
		<option value="9">高中</option>		
	</select>
	<h5>年級：</h5>
	<select id="gradeSelect">		
		<option value="1">一</option>
		<option value="2">二</option>
		<option value="3">三</option>
		<option value="4">四</option>
		<option value="5">五</option>
		<option value="6">六</option>		
	</select>		
	<span class="greenBtn" onclick="createMap()">建立知識結構圖</span>
	<hr />
	<h2>知識結構列表</h2><br />
	<div id="kmList">
		<ul>
		<?php 
		if(count($kmList)>0):?>
			<?php foreach ($kmList as $value): ?>
				<li><span>科目：<?php echo $value->subjectName;?></span><span>年級：
				<?php if($value->grade<=6): ?>
				<?php echo "國小 ".($value->grade)." 年級" ?>	
				<?php elseif($value->grade>6 && $value->grade<=9): ?>
				<?php echo "國中 ".($value->grade-6)." 年級" ?>	
				<?php elseif($value->grade>9 && $value->grade<=12): ?>
				<?php echo "高中 ".($value->grade-9)." 年級" ?>				
				<?php endif;?>
				</span><span class="blueBtn" onclick="openKm('<?php echo $value->id;?>')">查看</span>
				</li>
			<?php endforeach; ?>
		<?php else: ?>
			<li>尚未建立知識結構圖</li>	
		<?php endif; ?>
		</ul>
	</div>
</div>
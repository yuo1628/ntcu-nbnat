<div id="member">
	<h1>建立帳號</h1>
	<table>
		<tr><th>使用者帳號</th><td><input type="text"/></td></tr>
		<tr><th>使用者密碼</th><td><input type="password"/></td></tr>
		<tr><th>再次輸入密碼</th><td><input type="password"/></td></tr>
		<tr><th>權限</th><td>
			<select id="rank"></select>
		</td></tr>
		<tr><th colspan="2">所屬單位</th></tr>
		<tr><th>城市</th><td id="city" level="0">
			<?php if(count($city_list)>0):?>
			<select id="citySelect">		
			<?php $_title=""; ?>		
			<?php foreach ($city_list as $item): ?>					
				<?php if(substr($item->name,0,9)!=$_title): ?> 		
					<optgroup label="<?php echo substr($item->name,0,9)?>"></optgroup>
					<?php $_title=substr($item->name,0,9); ?>					
				<?php endif;?>	
				<?php echo "<option value='".$item->id."'>".substr($item->name,9,9)."</option>"; ?>
			<?php	endforeach; ?>
				</select>
				<span class="fontGray inputNewText">新增選項</span>
			<?php else: ?>
				 <input type="text" id="cityText"/>
			<?php endif; ?>
		</td></tr>
		<tr><th>學校類型</th><td id="schoolType" level="1">			
			<?php if(count($school_type)>0):?>
			<select id="schoolTypeSelect">
			<?php foreach ($school_type as $item): ?>		 
				<?php echo "<option value='".$item->type."'>".$item->type."</option>"; ?>
			<?php	endforeach; ?>
				</select>
				<span class="fontGray inputNewText">新增選項</span>
			<?php else: ?>
				 <input type="text" id="schoolTypeText"/>
			<?php endif; ?>	
		</td></tr>
		<tr><th>學校名稱</th><td id="schoolName" level="2">			
		</td></tr>		
		<tr><th>學校地址</th>
			<td id='schoolAddress' level='3'><input type='text' id='schoolAddressText' /></td>
		</tr>
		<tr><th>學校電話</th>
			<td id='schoolPhone' level='4'><input type='text' id='schoolPhoneText' /></td>
		</tr>
		<tr rank="0"><th>學制</th><td id="classType">
			<?php if(count($class_type)>0):?>
			<select id="schoolTypeSelect">
			<?php foreach ($class_type as $item): ?>		 
				<?php echo "<option value='".$item->type."'>".$item->type."</option>"; ?>
			<?php	endforeach; ?>
				</select>
				<span class="fontGray inputNewText">新增選項</span>
			<?php else: ?>
				 <input type="text" id="classTypeText"/>
			<?php endif; ?>	
		</td></tr>
		<tr rank="0"><th>年級</th><td id="classGrade">
			<?php if(count($class_grade)>0):?>
			<select id="schoolTypeSelect">
			<?php foreach ($class_grade as $item): ?>		 
				<?php echo "<option value='".$item->type."'>".$item->type."</option>"; ?>
			<?php	endforeach; ?>
				</select>
				<span class="fontGray inputNewText">新增選項</span>
			<?php else: ?>
				 <input type="text" id="classGradeText"/>
			<?php endif; ?>	
		</td></tr>
		<tr rank="0"><th>班別</th><td id="className">
			<?php if(count($class_name)>0):?>
			<select id="schoolTypeSelect">
			<?php foreach ($class_name as $item): ?>		 
				<?php echo "<option value='".$item->type."'>".$item->type."</option>"; ?>
			<?php	endforeach; ?>
				</select>
				<span class="fontGray inputNewText">新增選項</span>
			<?php else: ?>
				 <input type="text" id="classNameText"/>
			<?php endif; ?>	
		</td></tr>
		<tr><th colspan="2">基本資料</th></tr>
		<tr><th>姓名</th><td></td></tr>
		<tr><th>性別</th><td>
			<input type="radio" name="sex" value="0" checked="checked"/>男
			<input type="radio" name="sex" value="1"/>女
		</td></tr>
		<tr><th>生日</th><td></td></tr>
		<tr><th>身分證字號</th><td></td></tr>
		<tr><th>行動電話</th><td></td></tr>
		<tr><th>電話</th><td></td></tr>
		<tr><th>住址</th><td></td></tr>
		<tr><th>電子信箱</th><td></td></tr>
	</table>		
	<br />
	<span class="blueBtn" onclick="createMember()">建立</span>
</div>

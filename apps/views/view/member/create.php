<div id="member">
	<h1>建立帳號</h1>
	<table>
		<tr><th>使用者帳號</th><td><input type="text"/></td></tr>
		<tr><th>使用者密碼</th><td><input type="password"/></td></tr>
		<tr><th>再次輸入密碼</th><td><input type="password"/></td></tr>
		<tr><th>權限</th><td></td></tr>
		<tr><th colspan="2">所屬單位</th></tr>
		<tr><th>城市</th><td level="0">
			<?php if(count($city_list)>0):?>
			<select id="citySelect">
			<?php foreach ($city_list as $item): ?>		 
				<?php echo "<option value='".$item->id."'>".$item->name."</option>"; ?>
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
				<?php echo "<option value='".$item."'>".$item."</option>"; ?>
			<?php	endforeach; ?>
				</select>
				<span class="fontGray inputNewText">新增選項</span>
			<?php else: ?>
				 <input type="text" id="schoolTypeText"/>
			<?php endif; ?>	
		</td></tr>
		<tr><th>學校名稱</th><td id="schoolName" level="2">
			
		</td></tr>		
		<tr><th>學制</th><td id="classType"></td></tr>
		<tr><th>年級</th><td id="classGrade"></td></tr>
		<tr><th>班別</th><td id="className"></td></tr>
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

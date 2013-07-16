<div id="member">
	<h1>建立帳號</h1>
	<hr/>
	<table>
		<tr><th>使用者帳號</th><td><input type="text" id="username" /></td></tr>
		<tr><th>使用者密碼</th><td><input type="password" id="password" /></td></tr>
		<tr><th>再次輸入密碼</th><td><input type="password" id="secondPwd" /><span>X</span></td></tr>
		<tr><th>權限</th><td>
			<select id="rank"></select>
		</td></tr>
		<tr><th colspan="2">所屬單位</th></tr>
		<tr><th>縣市</th><td id="city" level="0">			
			<?php if(count($city_list)>0):?>
			<select id="citySelect">					
			<?php foreach ($city_list as $item): ?>	
				<?php echo "<option value='".$item->id."'>".$item->name."</option>";?>
			<?php	endforeach; ?>
				</select>
				<span class="fontGray inputNewText">新增選項</span>
			<?php else: ?>
				 <input type="text" id="cityText"/>
			<?php endif; ?>
		</td></tr>
		
		<tr><th>學校類型</th><td id="schoolType" level="2">			
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
		<tr><th>學校名稱</th><td id="schoolName" level="3">			
		</td></tr>		
		<tr><th>學校地址</th>
			<td id='schoolAddress' level='4'><input type='text' id='schoolAddressText' /></td>
		</tr>
		<tr><th>學校電話</th>
			<td id='schoolPhone' level='5'><input type='text' id='schoolPhoneText' /></td>
		</tr>
		<tr unit="0"><th>選擇單位</th>
		    <td>
		        <ul id="unitChoose">
		            <li><input type="checkbox" class="unitCheck" value="0">無</li>
		            <li><input type="checkbox" class="unitCheck" value="1">處室</li>
		            <li><input type="checkbox" class="unitCheck" value="2">班級</li>
		        </ul>		   
		    </td>
		</tr>
		<tr unit="1"><th>處室</th><td id="unitType" level='6'>     
            <input type='text' id='unitTypeText'/>             
        </td></tr>
		<tr unit="2"><th>學制</th><td id="classType" level='6'>		
			<input type='text' id='classTypeText'/>				
		</td></tr>
		<tr unit="2"><th>年級</th><td id="classGrade" level='7'>	
			<input type='text' id='classGradeText'/>					
		</td></tr>
		<tr unit="2"><th>班別</th><td id="className" level='8'>	
			<input type='text' id='classNameText' />			
		</td></tr>
		<tr><th colspan="2">基本資料</th></tr>
		<tr><th>姓名</th><td><input type="text" id="name" /></td></tr>
		<tr><th>性別</th><td>
			<input type="radio" name="sex" value="0" checked="checked"/>男
			<input type="radio" name="sex" value="1"/>女
		</td></tr>
		<tr><th>生日</th><td><input type="text" id="birthday" /></td></tr>
		<tr><th>身分證字號</th><td><input type="text" id="icNum" /></td></tr>
		<tr><th>行動電話</th><td><input type="text" id="phone" /></td></tr>
		<tr><th>電話</th><td><input type="text" id="tel" /></td></tr>
		<tr><th>住址</th><td><input type="text" id="address" /></td></tr>
		<tr><th>電子信箱</th><td><input type="text" id="email" /></td></tr>
	</table>		
	<br />
	<span class="blueBtn" onclick="createMember()">建立</span>
</div>

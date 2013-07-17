<div id="login">
	<ul>
		<li>
			<h6>使用者帳號</h6>
			<input type="text" id="username" class="textStyle" />
		</li>
		<li>
			<h6>使用者密碼</h6>
			<input type="password" id="password" class="textStyle" />
		</li>		
		<li>
			<!--<a href="./index.php/home" onclick="login('1');return false;" style="text-decoration:none;"><span class="greenBtn">學生登入</span></a>-->
			<span class="fontRed"><?php echo $mes;?></span>
		</li>
		<li>
			<span class="greenBtn" onclick="login()" >登入</span>
		</li>
		
	</ul>
</div>
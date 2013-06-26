

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<base href="/ntcu-nbnat/">
		<script type="application/javascript" src="js/jquery-1.9.1.js"></script>
		<script type="application/javascript" src="js/main.js"></script>
		<link rel="stylesheet" href="css/master.css" />
		<link rel="stylesheet" href="css/frame.css" />
		<link rel="stylesheet" href="css/index.css" />
		<link rel="stylesheet" href="css/news.css" />
	</head>
	<body>
		<div id="container">
			<div id="header">
				<div id="logo">
					<a href="./"></a>
				</div>
				<nav id="nav">
					<div id="login">
						<ul>
							<li>
								<h6>使用者帳號</h6>
								<input type="text" id="username" class="textStyle" />
							</li>
							<li>
								<h6>使用者密碼</h6>
								<input type="text" id="username" class="textStyle" />
							</li>
							<li>
								<a href=""><h6>忘記密碼？</h6></a>
							</li>
							<li>
								<a href="./index.php/home" onclick="login('0');return false;" style="text-decoration:none;"><span class="greenBtn">登入</span></a>
							</li>
							<li>
								<a href="./index.php/home" onclick="login('1');return false;" style="text-decoration:none;"><span class="greenBtn">學生登入</span></a>
							</li>
						</ul>

					</div>
				</nav>
			</div>
			<div id="content">
				<?php echo $content
				?>
			</div>
			<p id="footer">
				法律顧問 : 令衍法律事務所　台灣黃頁名錄 | 長泓露天拍賣 | 長泓資訊粉絲專頁　© 2013長泓資訊有限公司
			</p>
		</div>

	</body>
</html>
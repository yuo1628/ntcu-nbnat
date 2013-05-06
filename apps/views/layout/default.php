<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<base href="http://localhost/ntcu-nbnat/">
		<script type="application/javascript" src="js/jquery-1.9.1.js"></script>
		<script type="application/javascript" src="js/toggle.js"></script>
		<link rel="stylesheet" href="css/master.css" />
		<link rel="stylesheet" href="css/frame.css" />
		<link rel="stylesheet" href="css/menu.css" />
		
		
		
		
	</head>
	<body>
		<div id="container">
			<div id="container">
				<div id="header">
					<div id="logo"></div>
					<div id="nav">

					</div>
				</div>
				<div id="content">
					<div id="menu" class="divFrame">						
						<a id="toggle"></a>
						<ul>
						<?php
							for ($i = 1; $i <= count($itemList); $i++) {
								echo "<li><a href='" . $itemList["item" . $i][1] . "'><img src='" . $itemList["item" . $i][0] . "'/><span>" . $itemList["item" . $i][2] . "</span></a></li>";
							}
						 ?>
						 </ul>
					</div>
					<div id="main" class="divFrame">
						<?php echo $content; ?>
					</div>
				</div>
				<p id="footer">
					法律顧問 : 令衍法律事務所　台灣黃頁名錄 | 長泓露天拍賣 | 長泓資訊粉絲專頁　© 2013長泓資訊有限公司
				</p>
			</div>

	</body>
</html>
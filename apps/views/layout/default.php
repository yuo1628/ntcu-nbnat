

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<base href="/ntcu-nbnat/">
		<script type="application/javascript" src="js/jquery-1.9.1.js"></script>
		<script type="application/javascript" src="js/toggle.js"></script>
		<link rel="stylesheet" href="css/master.css" />
		<link rel="stylesheet" href="css/frame.css" />
		<link rel="stylesheet" href="css/menu.css" />
		<link rel="stylesheet" href="css/font.css" />
		<!-- css & js-->
		<?php 
			//include head
			echo $this->layout->fetchHead(); 
		?> 
		
	</head>
	<body>
		<div class="ajaxProressBox">
			<div class="ajaxProressBg">
				
			</div>
			<div class="ajaxProressText">
				
			</div>
		</div>
		
		<div id="container">
			<div id="header">
				<div id="logo">
					<a href="./"></a>
				</div>
				<div id="nav">

				</div>
			</div>
			<div id="content">
				<div id="menu" class="divFrame">						
					<div id="toggle">
						<div class="arrow"></div>
						</div>
					<ul>
					<?php foreach ($itemList as $item): ?>
						<li class="item">
							<a href="<?php echo $item[1] ?>">
								<span class="icon icon-<?php echo $item[0]?>">
									<span><?php echo $item[2] ?>
										
									</span>
								</span>
							</a>
						</li>
					<?php endforeach; ?>
					
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
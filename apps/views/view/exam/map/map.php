<?php

$l = $link->allLink();
$n = $node->allNode();

//print_r(array_merge($l,$n));

?>
<div class="mapContainer" style="position:fiexed;height: 100%;width:100%;overflow:hidden;left:0;top:0">
	<div class="controlBar">
			
		<div class="linkBtn btn cItem">
			上位連線
		</div>
		<div class="linkChildBtn btn cItem">
			下位連線
		</div>
		<div class="removeLinkBtn btn cItem">
			移除上位關聯
		</div>
		<div class="removeChildLinkBtn btn cItem">
			移除下位關聯
		</div>
		<div class="removePointBtn btn cItem">
			移除節點
		</div>
		<label class="cItem">文字</label>
		<input class="pointText cItem" type="text" />
		<div class="checkBtn cItem">
			設定
		</div>
		<div class="saveBtn btn cItem">
			存檔
		</div>
		<div class="updBtn btn cItem">
			更新
		</div>
		<div class="readBtn btn cItem">
			讀檔
		</div>
		<div class="groupBtn btn cItem">
			顯示群組
		</div>
		
		<div class="splitLine cItem">
			
		</div>
		
		<div class="lockBtn btn cItem">
			單元上鎖
		</div>
		
		<div class="gotoTopicBtn btn cItem">
			管理試題
		</div>
		
		<div class="clearFix"></div>
	</div>
	<div class="zoomBox">
		<div class="zoomIn">
			+
		</div>
		<div class="zoomScrollBar">
			<div class="zoomScrollRect">
			
			</div>
		</div>
		<div class="zoomOut">
			-
		</div>
	</div>
	<div class="toolsBar">			
		<div class="addPointL1Btn btn">
			增加大節點
		</div>
		
		<div class="addPointL0Btn btn">
			增加小節點
		</div>
		
		<!--
		<div class="upPosBtn btn">
			顯示上位
		</div>
		
		
		<div class="downPosBtn btn">
			全部顯示
		</div>
		-->
	</div>
	<div class="mapBox">
	
		<div class="debug">
			
		</div>
		
		<div class="mapBg">
	
	<?php
	for($i = 0; $i < 1000 ;$i++):
		$r = rand(150, 255);
		$g = rand(150, 255);
		$b = rand(150, 255);
		$left = rand(0,5000);
		$top = rand(0,5000);
		$width = rand(0,5);
		$height = rand(0,5);
		
		//$left = 960 +round(sin($i) * $i);
		//$top = 540 + round(cos($i) * $i / 4);
	?>
	<div class="star" style="position:absolute;
	background-color: rgb(<?php echo $r ?>, <?php echo $g ?>, <?php echo $b ?>);
	width: <?php echo $width ?>px;  
	height: <?php echo $height ?>px; 
	left: <?php echo $left ?>px; 
	top: <?php echo $top ?>px; 
	
	"></div>
	<?php endfor; ?>
	
	<?php
	/*
	for($i = 0; $i < 1560 ;$i++):
		$r = rand(150, 255);
		$g = rand(150, 255);
		$b = rand(150, 255);
		//$left = rand(0,2560);
		//$top = rand(0,1680);
		$width = rand(0,10);
		$height = rand(0,10);
		
		$left = 960 + round(sin(rand(0,360)) * $i / 6);
		$top = 540 + round(cos(rand(0,360)) * $i / 12);
	?>
	<div style="position:fixed;
	background-color: rgb(<?php echo $r ?>, <?php echo $g ?>, <?php echo $b ?>);
	width: <?php echo $width ?>px;  
	height: <?php echo $height ?>px; 
	left: <?php echo $left ?>px; 
	top: <?php echo $top ?>px; 
	
	"></div>
	<?php endfor; */?>
	
</div>
<div class="mapBgClose">X</div>
		
		<div class="canvas">
		</div>
		
		
	</div>
</div>




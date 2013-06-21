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
			<div class="clearFix"></div>
		</div>
		<div class="toolsBar">			
			<div class="addPointBtn btn">
				增加節點
			</div>
			
			<div class="upPosBtn btn">
				顯示上位
			</div>
			
			
			<div class="downPosBtn btn">
				全部顯示
			</div>
		</div>
	<div class="mapBox">
	
		<div class="debug">
			
		</div>
		
		
		<div class="canvas">
			
		</div>
	</div>
</div>

<div class="mapBg"></div>
<div class="mapBgClose">X</div>


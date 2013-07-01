<?php foreach (json_decode($tipStep[0]->tips) as $i=>$item):?>
	<div class="tipsFrame">
		<p>
			Step <?php echo $i+1;?>
		</p>	
		<div class="tipContent">
		<?php echo $item;?>
		</div>
		<div class="step">
		<span class="up" onclick="previousStep('<?php echo $tipStep[0]->id; ?>',<?php echo $i; ?>)">上一步</span>
		<span class="down" onclick="nextStep('<?php echo $tipStep[0]->id; ?>',<?php echo $i; ?>)">下一步</span>		
		</div>
		<div style="clear:both;"></div>
	</div>
<?php endforeach;?>


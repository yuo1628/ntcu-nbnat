<ul id="childList">
	<?php foreach ($childList as $item):?>
	<li>
	<div class="lockState">
		<div class="<?php echo $item -> lock; ?>"></div>
	</div>
	<div class="quiz">
	<h3><?php echo $item -> name; ?></h3>
		<div class="state">
			<?php echo $item -> count_total; ?>
			<?php echo $item -> count_open; ?>	
			<div class="btn">
			</div>
		</div>
	</div>
	</li>
	<?php endforeach; ?>
</ul>
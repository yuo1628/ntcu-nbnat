<select>
	<?php foreach($optionList as $item):?>
	<option value="<?php echo $item->id; ?>"><?php echo $item->name ?></option>
	<?php endforeach; ?>
</select>
<span class="fontGray inputNewText">新增選項</span>
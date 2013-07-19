<div id="memberEDit">
	<h1>個人資料</h1>
	<hr/>
	<?php $user = $member_profile[0];
		$class = $member_class[0];

		echo $user->id . "<br/>";
		echo $user->username . "<br/>";
		echo $user->password . "<br/>";
		echo $user->name . "<br/>";
		echo $user->sex . "<br/>";
		echo $user->rank . "<br/>";
		echo $user->birthday . "<br/>";
		echo $user->ic_number . "<br/>";
		echo $user->phone . "<br/>";
		echo $user->tel . "<br/>";
		echo $user->address . "<br/>";
		echo $user->email . "<br/>";
		echo $user->created_time . "<br/>";
		echo $user->password_edited_time . "<br/>";
		print_r($member_class);
	?>
	<ul>
	    <li><h4>基本資料</h4><div></div></li>
	    <li><h4>服務單位</h4><div></div></li>
	    <li><h4>聯絡資訊</h4><div></div></li>
	    <li><h4>電子信箱</h4><div></div></li>
	    <li><h4>密碼</h4><div><?php echo (empty($user -> password_edited_time)) ? "尚未更改過密碼" :$user -> password_edited_time; ?></div></li>
	</ul>
</div>

<div id="member">
	<h1>個人資料</h1>
	<hr/>
	<?php $user = $member_profile[0];
        $class = $member_class[0];

        echo $user -> id . "<br/>";
        echo $user -> username . "<br/>";
        echo $user -> password . "<br/>";
        echo $user -> name . "<br/>";
        echo $user -> sex . "<br/>";
        echo $user -> rank . "<br/>";
        echo $user -> birthday . "<br/>";
        echo $user -> ic_number . "<br/>";
        echo $user -> phone . "<br/>";
        echo $user -> tel . "<br/>";
        echo $user -> address . "<br/>";
        echo $user -> email . "<br/>";
        echo $user -> created_time . "<br/>";
        echo $user -> password_edited_time . "<br/>";
        print_r($member_class);
	?>
	<ul>
	    <li>密碼</li>
	    <li>班級</li>
	    <li>基本資料</li>
	    <li>聯絡電話</li>
	    <li>電子信箱</li>
	</ul>
	<table>
      
        <tr><th>密碼</th><td><?php  echo $user -> password_edited_time; ?></td></tr>
       
        <tr><th colspan="2">所屬單位</th></tr>        
        
        
        
        <tr rank="0"><th>學制</th><td id="classType">       
              <?php echo $class -> type; ?>          
        </td></tr>
        <tr rank="0"><th>年級</th><td id="classGrade">  
                 <?php echo $class -> grade; ?>             
        </td></tr>
        <tr rank="0"><th>班別</th><td id="className">   
                <?php echo $class -> name; ?>       
        </td></tr>
        <tr><th colspan="2">基本資料</th></tr>
        <tr><th>姓名</th><td></td></tr>
        <tr><th>性別</th><td>
           
        </td></tr>
        <tr><th>生日</th><td></td></tr>
        <tr><th>身分證字號</th><td></td></tr>
        <tr><th>行動電話</th><td></td></tr>
        <tr><th>電話</th><td></td></tr>
        <tr><th>住址</th><td></td></tr>
        <tr><th>電子信箱</th><td></td></tr>
    </table>    
</div>

<?php
// Anticipate
//    - string $post_url
//    - array $types 輸出檔案格式
//    - array $infos
//    - array $errors
?>
<ul>
    <?php foreach ($errors as $error): ?>
        <li><?php echo $error ?></li>
    <?php endforeach; ?>
</ul>

<ul>
    <?php foreach ($infos as $info): ?>
        <li><?php echo $info ?></li>
    <?php endforeach; ?>
</ul>

<form action="<?php echo $post_url ?>" method="post" enctype="multipart/form-data">
    <input type="file" required name="excel" />
    <label>檔案是否有包含標題?<input type="checkbox" name="hastitle" /></label>
    <input type="hidden" name="submit" value="1" />
    <input type="submit" value="匯入會員資料" />
</form>

<form action="<?php echo $post_url ?>" method="post">
    <select name="type" required>
        <option value="">請選擇輸出檔案類型</option>
        <?php foreach ($types as $type): ?>
            <option value="<?php echo $type ?>"><?php echo $type ?></option>
        <?php endforeach ?>
    </select>
    <input type="hidden" name="submit" value="2" />
    <input type="submit" value="匯出會員資料" />
</form>
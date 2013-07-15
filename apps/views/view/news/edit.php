<?php
// anticipate
//  - News $news
//  - string $post_url
//  - string $download_url
//  - array $cagegory_list
//  - array $errors
//  - string $title
?>

<ul>
	<?php foreach ($errors as $error): ?>
		<li><?php echo $error ?></li>
	<?php endforeach ?>
</ul>
<h1><?php echo $title ?></h1>
<form action="<?php echo $post_url ?>" method="post" enctype="multipart/form-data">
	<p><label>標題：<input type="text" name="title" value="<?php echo $news->title ?>"/></label></p>
	<p><label>內文：<textarea name="content"><?php echo $news->content ?></textarea></label></p>
	<p>
		<label>附件：<input type="file" multiple name="files[]" /></label>
		<ul>
		<?php foreach($news->files as $file): ?>
			<li>
				<a href="<?php echo $download_url . "/{$file->id}" ?>"><?php echo $file->name ?></a>
				<input type="hidden" name="news_id" value="<?php echo $news->id ?>" />
				<input type="hidden" name="file_id" value="<?php echo $file->id ?>" />
				<input type="submit" value="刪除" name="delete_edit_file" />
			</li>
		<?php endforeach ?>
		</ul>
	</p>
	<p>
		<select name="category" required>
			<option value="">請選擇公告分類</option>
			<?php foreach ($category_list as $category): ?>
				<option value="<?php echo $category->id ?>" <?php
                if (!is_null($news -> category) && $category -> id == $news -> category -> id) : echo 'selected';
                endif;
 ?>>
				<?php echo $category->name ?></option>
			<?php endforeach ?>
		</select>
	</p>
	<p><input type="submit" value="<?php echo $title ?>" name="edit"/></p>
</form>
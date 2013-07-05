<?php
// Anticipate
//   - News $news
?>
<h1><?php echo $news->title ?></h1>
<pre><?php echo $news->content ?></pre>

<?php if ($news->files): ?>
<h2>附件</h2>
	<ul>
		<?php foreach ($news->files as $file): ?>
			<li><a href="<?php echo $download_url . "/{$file->id}" ?>"><?php echo $file->name ?></a></li>
		<?php endforeach ?>
	</ul>
<?php endif ?>
<h2>分類</h2>
<p><?php echo $news->category->name ?></p>
<h2>作者</h2>
<p><?php echo $news->author->name ?></p>
<h2>發佈時間</h2>
<p><?php echo $news->publish_time ?></p>
<h2>最後修改時間</h2>
<p><?php echo $news->edit_time ?></p>
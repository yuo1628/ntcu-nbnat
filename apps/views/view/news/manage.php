<?php
// anticipate
//   - array $news_list 包含News類別實體的陣列
//   - string $read_url 讀取指定公告的URL
//   - Pagination $pagination 分頁類別
//   - string $order
//   - string $order_by
//   - string $manage_url
//   - string $redirect_url

function build_url($order_by, $order, $prefix_url, $page=NULL)
{
	return $prefix_url . "/{$order_by}/{$order}" . ($page ? "/{$page}" : '');
}
?>
<?php if ($news_list): ?>
	<table border="1">
		<caption>管理公告</caption>
		<thead>
			<tr>
				<th>標題</th>
				<th>作者</th>
				<th><a href="<?php echo ($order_by == 'publish_time' && $order == 'desc') ? build_url('publish_time', 'asc', $manage_url) : build_url('publish_time', 'desc', $manage_url) ?>">發佈時間</a></th>
				<th><a href="<?php echo ($order_by == 'edit_time' && $order == 'desc') ? build_url('edit_time', 'asc', $manage_url) : build_url('edit_time', 'desc', $manage_url) ?>">修改時間</a></th>
				<th><a href="<?php echo ($order_by == 'category' && $order == 'desc') ? build_url('category', 'asc', $manage_url) : build_url('category', 'desc', $manage_url) ?>">分類</a></th>
				<th colspan="2">操作</th>
			</tr>
		</thead>
		<tfoot>
			<p><?php echo $pagination->create_links() ?></p>
		</tfoot>
		<tbody>
		<?php foreach ($news_list as $news): ?>
			<tr>
				<td><a href="<?php echo $read_url . "/{$news->id}" ?>"><?php echo $news->title ?></a></th>
				<td><?php echo $news->author->name ?></td>
				<td><?php echo $news->publish_time ?></td>
				<td><?php echo $news->edit_time ?></td>
				<td><?php echo $news->category->name ?></td>
				<td>
					<form action="<?php echo "./index.php/news/edit/{$news->id}" ?>" method="get">
						<input type="submit" value="編輯" />
					</form>
				</td>
				<td>
					<form action="./index.php/news/delete" method="post">
						<input type="hidden" name="id" value="<?php echo $news->id ?>" />
						<input type="hidden" name="redirect_url" value="<?php echo build_url($order_by, $order, $redirect_url, ($pagination->cur_page - 1) * $pagination->per_page) ?>" ?>
						<input type="submit" value="刪除"/>
					</form>
				</td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
<?php else: ?>
	<h1>無任何公告</h1>
<?php endif ?>
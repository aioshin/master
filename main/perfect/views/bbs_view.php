<!DOCTYPE html>
<head>
	<title>一言掲示板</title>
	<meta charset="utf-8">
</head>
<body>
	<form method="POST" action="bbs.php">
		<?php if(count($errors)): ?>
		<ul class="error_list">
			<?php foreach($errors as $er): ?>
			<li>
				<?php echo htmlspecialchars($er, ENT_QUOTES, 'UTF-8') ?>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<p>
			名前を入力してください：
			<input type="text" name="name">
			<br>
			ひとこと：
			<input type="text" name="comment">
			<br>
			<input type="submit" value="送信">
		</p>
	</form>
	<?php if(count($posts) > 0): ?>
	<ul>
		<?php foreach ($posts as $post): ?>
		<li>
			<?php echo htmlspecialchars($post['name'], ENT_QUOTES, 'UTF-8'); ?>:
			<?php echo htmlspecialchars($post['comment'], ENT_QUOTES, 'UTF-8'); ?>
			- <?php echo htmlspecialchars($post['created_at'], ENT_QUOTES, 'UTF-8'); ?>
		</li>
		<?php endforeach; ?>
	</ul>
	<?php endif; ?>
	
</body>
</html>

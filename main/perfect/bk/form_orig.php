<!DOCTYPE html>
<head>
	<title>オリジナル版</title>
	<meta charset="utf-8">
</head>
<body>
	<form action="form_orig.php" method="POST">
		<p>名前を入力してください：</p>
		<input type="text" name="snd_str">
		<input type="submit" value="send!">
	</form>
	<?php
		echo htmlspecialchars($_POST['snd_str']),"さん";
	?>
</body>
</html>

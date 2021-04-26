<?php
// 引数：連想配列
//	type: name/comment
//	type_ja: 名前/コメント
//	len : 40/200
//	val : 入力データ
//
//  retern true/false

function isNameValid(string $dataType){
	if(!isset($dataType) || !strlen($dataType)){
		return false;
	}
}

function isLengthValid(array $data){
	if(strlen($_POST[$data->type]) > $data->len){
		return false;
	}
}

//DB接続
$link = mysqli_connect('localhost', 'root', 'masa2', 'online_bbs');
if(!$link){
	die('データベースに接続できません'. mysql_error());
}

$errors = array();
//POST時には保存処理実行
if($_SERVER['REQUEST_METHOD'] === 'POST'){

	////名前チェック
	$ary_name= [
		"type" => "name",
		"type_ja" => "名前",
		"len" => 40
	];
	if(!isNameValid($_POST[$data->type])){
		$errors[$data->type] = $data->type_ja . "を入力してください";
	}
	if(!isLengthValid($ary_name)){
		$errors[$data->type] = $data->type_ja . "は" . $data->len . "文字以内で入力してください";
	}

	////一言チェック
	$ary_comment= [
		"type" => "comment",
		"type_ja" => "コメント",
		"len" => 200
	];
	if(!isNameValid($_POST[$data->type])){
		$errors[$data->type] = $data->type_ja . "を入力してください";
	}
	if(!isLengthValid($ary_name)){
		$errors[$data->type] = $data->type_ja . "は" . $data->len . "文字以内で入力してください";
	}

	//エラーがなければ保存
	if(count($errors) === 0){
		//保存用SQL作成
	 	$sql = "INSERT INTO post(name, comment, created_at) VALUES('"
			. mysqli_real_escape_string($link,$name) . "' ,'"
			. mysqli_real_escape_string($link,$comment) . "' ,'"
			. date('Y-m-d H:i:s') . "')";
		$rel = mysqli_query($link, $sql);
	}
	else{
		foreach($errors as $er) {
			echo $er, "<br>";
		}
		echo "<a href='form.php'>戻る</a>";
		exit();
	}
}
?>
<!DOCTYPE html>
<head>
	<title>一言掲示板</title>
	<meta charset="utf-8">
</head>
<body>
	<p>
		名前:
			<?php echo $_POST['name']; ?>
		ひとこと:
			<?php echo $_POST['comment']; ?>
	</p>
</body>
</html>

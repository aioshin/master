<?php

include 'common.php';

//DB接続
$link = mysqli_connect('localhost', 'root', 'masa2', 'online_bbs');
if(!$link){
	die('データベースに接続できません'. mysql_error());
}

$errors = array();

//POST時には保存処理実行
if($_SERVER['REQUEST_METHOD'] === 'POST'){

	////名前チェック
	$ary_name = [
		"type" => "name",
		"type_ja" => "名前",
		"len" => 40,
		"val"
	];
	$ary_name["val"]=$_POST["name"];
	
	isCheckParent($ary_name, $errors);

	////一言チェック
	$ary_comment = [
		"type" => "comment",
		"type_ja" => "コメント",
		"len" => 200,
		"val"
	];
	$ary_comment["val"]=$_POST["comment"];

	isCheckParent($ary_comment, $errors);
	
	//エラーがなければ保存
	if(count($errors) === 0){
		//保存用SQL作成
	 	$sql = "INSERT INTO post(name, comment, created_at) VALUES('"
		. mysqli_real_escape_string($link,$ary_name["val"]) . "' ,'"
		. mysqli_real_escape_string($link,$ary_comment["val"]) . "' ,'"
		. date('Y-m-d H:i:s') . "')";
		$rel = mysqli_query($link, $sql);
		mysqli_close($link);
		// リダイレクト処理
		header('Location: http://' .$_SERVER['HTTP_HOST'] .$_SERVER['REQUEST_URI']);
	}
}

// 投稿された内容を取得する
$sql = "SELECT * FROM `post` ORDER BY `created_at` DESC";
$result = mysqli_query($link, $sql);

if($result != false && mysqli_num_rows($result)){
	while ($post = mysqli_fetch_assoc($result)){
		$posts[] = $post;
	}
}
	
// SQLを閉じる
mysqli_free_result($result);
mysqli_close($link);

include './views/bbs_view.php';


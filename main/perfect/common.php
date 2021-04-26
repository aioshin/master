<?php
// 引数：連想配列
//	type: name/comment
//	type_ja: 名前/コメント
//	len : 40/200
//	val : 入力データ
//
//  retern true/false

//値が正しく設定されているかどうかをチェックする
function isSetValid(string $dataType){
	if(!isset($dataType) || strlen($dataType) <= 0){
		return false;
	}
	else{
		return true;
	}
}

//値の長さが既定値に収まっているかどうかをチェックする
function isLengthValid(array $data){
	if(strlen($data["val"]) > $data["len"]){
		return false;
	}
	else{
		return true;
	}
}

//各種データチェックの親関数
function isCheckParent(array $ary_data, array &$errors){

	if(!isSetValid($ary_data["val"])){
		$errors[$ary_data["type"]] = $ary_data["type_ja"] . "を入力してください";
	}
	if(!isLengthValid($ary_data)){
		$errors[$ary_data["type"]] = $ary_data["type_ja"]. "は" . $ary_data["len"]. "文字以内で入力してください";
	}
}

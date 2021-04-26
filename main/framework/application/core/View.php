<?php

class View
{
	protected $base_dir;
	protected $defaults;
	protected $layout_variables = array();

	public function __construct($base_dir, $defaults = array())
	{
		$this->base_dir = $base_dir;
		$this->defaults = $defaults;
	}

	public function setLayoutVar($name, $value)
	{
		$this->layout_variables[$name] = $value;
	}

	public function render($_path, $_variables = array(), $_layout = false)
	{
		$_file = $this->base_dir . '/' . $_path . '.php';

		extract(array_merge($this->defaults, $_variables));
		//extract()は連想配列を引数として、そのKeyを変数名、valueを値をとして変数を定義する関数

		ob_start();
		//viewでは出力結果をその場で出すのではなくレスポンスに含めるためにアウトプットバッファリングという機能を用いる
		//ob_startはその開始の合図の関数

		ob_implicit_flush(false);			//自動フラッシュをOFF
		
		require $_file;

		$content = ob_get_clean();		//中身を出力＆バッファリングオフ

		if($_layout){
			$content = $this->render($_layout, array_merge($this->layout_variables, array('_content'=>$content,)));
		}
		return $content;
		
	}

	public function escape($string)
	{
		return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
	}

}	

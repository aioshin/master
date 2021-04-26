<?php

class ClassLoader
{
	protected $dirs;

	public function register()
	{
		sql_autoload_register(array($this, 'loadClass')); //ここではarray関数で配列を生成してそれを引数として処理する、ということをしている
	}

	public function registerDir($dir)
	{
		$this->dirs[] = $dir;
	}

	public function loadClass($class)
	{
		foreach ($this->dirs as $dir){
			$file = $dir . '/' . $class . '.php';
			if(is_readable($file)){
				require $file;
				return;
			}
		}
	}
}
			

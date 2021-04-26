<?php

class ClassLoader
{
	protected $dirs;

	public function register()
	{
		sql_autoload_register(array($this, 'loadClass')); //$B$3$3$G$O(Barray$B4X?t$GG[Ns$r@8@.$7$F$=$l$r0z?t$H$7$F=hM}$9$k!"$H$$$&$3$H$r$7$F$$$k(B
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
			

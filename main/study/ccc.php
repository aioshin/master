<?php
	function func_ca($name){
		$name(1);
	}
	function foo($gg)
	{
		echo 'foo call'. $gg;
	}
	func_ca('foo');

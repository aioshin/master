<?php
class ssss
{
	private $meter;
	const TIMES__ = 2000;

	public function works(){
		echo 'working';
		echo $this->meter;
		echo PHP_EOL;
	}

	public function myMeterSet($set_data){
		$this->meter = $set_data;
	}

	static public function public_works(){
		echo 'hyper_working!!!';
	}
}

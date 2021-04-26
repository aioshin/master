<?php
class TestMan
{
	private $ggg;

	public function __toString()
	{
		return 'my name is'. __CLASS__;
	}
	public function __get($target)
	{
		echo 'is No!!';
	}
	public function second()
	{
		echo '2nd!';
	}
}

$test = new TestMan();
echo $test, PHP_EOL;
echo $test->ggg, PHP_EOL;
$test->second();

$dd = 100;
$ee = 200;
echo $dd, $ee, PHP_EOL;

$gg = &$dd;
$gg = 300;
echo $gg, $dd;

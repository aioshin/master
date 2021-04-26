<?php
	$bb = 'aaa';
	$aaa;
	$aaa = 1000;
	echo $$bb,PHP_EOL;
	#rensyu aa
  
	$ddd;
	$ddd = false ? "yes" : "no";
	echo $ddd;
?>
<?php if ($aaa === 1001){ ?>
<p>
yesyesyes
</p>
<?php }else{ ?>
<p>
nononono
</p>
<?php }; ?>

<?php
	require_once 'bbb.php';
	#roar2(roar(999));
	roar3('roar');

	require_once 'ddd.php';
#	$mnmn = new ssss();
#	$mnmn->myMeterSet(444);
#	$mnmn->works();
	ssss::public_works();
	echo PHP_EOL, ssss::TIMES__, PHP_EOL;

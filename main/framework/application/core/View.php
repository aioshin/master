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
		//extract()$B$OO"A[G[Ns$r0z?t$H$7$F!"$=$N(BKey$B$rJQ?tL>!"(Bvalue$B$rCM$r$H$7$FJQ?t$rDj5A$9$k4X?t(B

		ob_start();
		//view$B$G$O=PNO7k2L$r$=$N>l$G=P$9$N$G$O$J$/%l%9%]%s%9$K4^$a$k$?$a$K%"%&%H%W%C%H%P%C%U%!%j%s%0$H$$$&5!G=$rMQ$$$k(B
		//ob_start$B$O$=$N3+;O$N9g?^$N4X?t(B

		ob_implicit_flush(false);			//$B<+F0%U%i%C%7%e$r(BOFF
		
		require $_file;

		$content = ob_get_clean();		//$BCf?H$r=PNO!u%P%C%U%!%j%s%0%*%U(B

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

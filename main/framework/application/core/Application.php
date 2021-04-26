<?php

abstract class Application
{
	protected $debug = false;
	protected $request;
	protected $response;
	protected $session;
	protected $db_manager;
	protected $login_action = array();

	public function __construct($debug = false)
	{
		$this->setDebugMode($debug);
		$this->initialize();
		$this->cofigure();
	}

	public function run()
	{
		try {
			$params = $this->router->resolve($this->request->getPathInfo());
			//request$B$G<u$1<h$C$?%Q%9>pJs$r(Bresolve$B$KEO$9$3$H$G%k!<%F%#%s%0@h$rF~<j(B
			if($params === false){
				//todo-A
				throw new HttpNotFoundException('No route found for '. $this->request->getPathInfo());
			}

			$controller = $params['controller'];
			$action = $params['action'];

			$this->runAction($controller, $action, $params);
		} catch(HttpNotFoundException $e){
			$this->render404Page($e);

		} catch(UnauthorizedActionException $e){
			list($controller, $action) = $this->login_action;
			$this->runAction($controller. $action);
		}

		$this->response->send();
	}

	public function render404Page($e)
	{
		$this->response->setStatusCode(404, 'Not Found');
		$message = $this->isDebugMode() ? $e->getMessage() : 'Page not found.';
		$message = htmlspecialchars($message, ENT_QUOTES, 'UFT-8');

		$this->response->setContent(<<<EOF
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<title>404</title>
</head>
<body>
	{$message}
</body>
</html>
EOF
		);
	}

	public function runAction($controller_name, $action, $params = array())
	{
		$controller_class = ucfirst($controller_name). 'Controller';

		$controller = $this->findController($controller_class);
		if($controller === false) {
			//todo-B
			throw new HttpNotFoundException($controller_class . ' controller is not found.');
		}
		$content = $controller->run($action, $params);

		$this->response->setContent($content);
	}

	protected function findController($controller_class)
	{
		if(!class_exists($controller_class)){
			$controller_file = $this->getControllerDir() . '/' . $controller_class . '.php';

			if(!is_readable($controller_file)){
				return false;
			}
			else{
				require_once $controller_file;

				if(!class_exists($controller_class)){
					return false;
				}
			}
		}
		return new $controller_class($this);

	}

	protected function setDebugMode($debug)
	{
		if($debug){
			$this->debug = true;
			ini_set('display_errors', 1);			//ini_set$B$O(Bphp.ini$B$N@_Dj$rF0E*$KJQ99$9$k4X?t!#$3$N>l9g%(%i!<$r(Bhtml$B$KI=<($7$J$$%*%W%7%g%s$rM-8z2=(B
			error_reporting(-1);							//error_reporting$B$O%(%i!<I=<(@_DjMQ4X?t!#(B-1$B$N0z?t$OA4$FI=<($N0U(B
		}
		else{
			$this->debug = false;
			ini_set('display_errors', 0);
		}
	}

	protected function initialize()
	{
		$this->request = new Request();
		$this->response = new Response();
		$this->session = new Session();
		$this->db_manager = new DbManager();
		$this->router = new Router($this->registerRoutes());		//this$B$H$+$D$1$F$k$1$I(B$router$B$J$s$FDj5A$7$F$J$$$,!D(B
	}

	protected function configure()
	{
	}

	abstract public function getRootDir();

	abstract protected function registerRoutes();

	public function isDebugMode()
	{
		return $this->debug;
	}

	public function getRequest()
	{
		return $this->request;
	}

	public function getResponse()
	{
		return $this->response;
	}

	public function getSession()
	{
		return $this->session;
	}

	public function getDbManager()
	{
		return $this->db_manager;
	}

	public function getControllerDir()
	{
		return $this->getRootDir() . '/controllers';
	}

	public function getVieDir()
	{
		return $this->getRootDir() . '/views';
	}

	public function getModelDir()
	{
		return $this->getRootDir() . '/models';
	}

	public function getWebDir()
	{
		return $this->getRootDir() . '/web';
	}
}

		

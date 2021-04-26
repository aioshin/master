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
			//requestで受け取ったパス情報をresolveに渡すことでルーティング先を入手
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
			ini_set('display_errors', 1);			//ini_setはphp.iniの設定を動的に変更する関数。この場合エラーをhtmlに表示しないオプションを有効化
			error_reporting(-1);							//error_reportingはエラー表示設定用関数。-1の引数は全て表示の意
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
		$this->router = new Router($this->registerRoutes());		//thisとかつけてるけど$routerなんて定義してないが…
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

		

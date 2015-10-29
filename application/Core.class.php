<?php
namespace MyFramework;

class Core {

	static protected $_pdo;
	static protected $user = "root";
	static protected $password = "";
	static protected $database = "my_framework";
	static protected $host = "localhost";
	static protected $_routing = [];
	static private $_render;
	static protected $user_table = 'users';
	static protected $user_column_rank = 'rank';

	public function __construct() {
		self::$_pdo = new \PDO('mysql:host='.self::$host.';dbname=' . self::$database, self::$user, self::$password);
	}

	public function run() {
		$o = $this->routing();
		if (method_exists($o, $a = self::$_routing['action'] . 'Action')) {
			$o->$a();
		} else {
			self::$_render = "Impossible de trouver la methode" . PHP_EOL;
		}
		echo self::$_render;
 	}

	private function routing() {
		$url = explode('/', $_SERVER['REQUEST_URI']);
		array_shift($url);
		array_shift($url);
		$urlStr = implode('/', $url);
		$reqRouting = self::$_pdo->query('SELECT * FROM routing WHERE url = "'.$urlStr.'"')->fetch();
		if($reqRouting) {
			$reqRouting = explode('/', $reqRouting['real_path']);
			$action = end($reqRouting);
			$controller = $reqRouting[0];
		} else {
			$action = end($url);
			$controller = $url[0];
		}

		$callController = __NAMESPACE__ . '\\' . ucfirst($controller) .'Controller';
		if(class_exists($callController)) {
			$o = new $callController();
			if(!method_exists($o, $action.'Action')){
				$action = 'default';
			}
		} else {
			$controller = 'default';
			$callController = __NAMESPACE__ . '\\' . ucfirst($controller) .'Controller';
			$o = new $callController();
			if(!method_exists($o, $action.'Action')){
				$action = 'default';
			}			
		}

		self::$_routing = [
			'controller' => $controller,
			'action' => $action,
	 	];

	 	return $o;
	}

	private function renderFnc($params, $layout) {
		if($layout && isset($this->layout)){
			if(file_exists('views/'.$this->layout)){
				$l = file_get_contents('views/'.$this->layout);
			}
		}

		$f = implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'views', self::$_routing['controller'], self::$_routing['action']]) . '.html';
		if (file_exists($f)) {
			$c = file_get_contents($f);
			foreach ($params as $k => $v) {
				$c = preg_replace("/\{\{\s*$k\s*\}\}/", $v, $c);
	 		}
	 		if(isset($l)){
	 			self::$_render = preg_replace("/\{\{\s*content\s*\}\}/", $c, $l);
	 		} else {
	 			self::$_render = $c;
	 		}
	 	} else {
	 		self::$_render = "Impossible de trouver la vue" . PHP_EOL;
	 	}
	}

	protected function render($params = []) {
		$this->renderFnc($params, true);
	}

	protected function renderPartial($params = []) {
		$this->renderFnc($params, false);
	}
}
?>
<?php

class Bootstrap {

	protected $controller;
	protected $controllers;
	protected $method;
	protected $url;
	protected $flag = 0;
	protected $nick;
	protected $real;
	protected $params;
	protected $bound = -1;
	protected $a = 1;

	public function __construct() {
		
		require APP_DIR . 'config/routes.php';
		$this->url = isset($_GET['url']) ? $_GET['url'] : null;
		$this->url = rtrim($this->url, '/');
		$this->url = explode('/', $this->url);

		if(isset($routes)) {

			foreach($routes as $key => $value) {

				$this->nick = $key;

				$this->real = $value;
				
				$this->nick = rtrim($key, '/');
				$this->nick = explode('/', $key);

				$this->real = rtrim($value, '/');
				$this->real = explode('/', $value);
				
				for($i = 0; $i < count($this->nick); $i++) {
					if(preg_match_all('~\[@(.+?)\]~', $this->nick[$i], $matches) != 0) {
						$bound = $i;
						break;
					}
				}
				@$urll = '';
				@$furl = '';
				if((@$bound + 1) == 2) {
					@$urll = $this->nick[0] . '/' . $this->url[$bound];
					@$furl = $this->nick[0] . '/index/' . $this->url[$bound];
				}				
				else if((@$bound + 1) == 1) {
					@$urll =  $this->url[$bound];
					@$furl =  'home/index/' . $this->url[$bound];
				}
				//echo 'Real URL: ' . $urll . '<br> Fake URL: ' . $furl;

				if(@$_GET['url'] == $urll) {
					$this->controller = empty($this->real[0]) ? 'Home' : $this->real[0];

					$this->method =  empty($this->real[1]) ? 'Index' : $this->real[1];

					$this->params = $this->url[$bound];
					break;

				} else if(@$_GET['url'] == $key) {
					$this->controller = empty($this->real[0]) ? 'Home' : $this->real[0];

					$this->method =  empty($this->real[1]) ? 'Index' : $this->real[1];
					
					break;
				} 
				else {
					$this->controller = empty($this->url[0]) ? 'Home' : $this->url[0];

					$this->method = empty($this->url[1]) ? 'Index' : $this->url[1];
				}
			}
		} else {
			$this->controller = empty($this->url[0]) ? 'Home' : $this->url[0];

			$this->method = empty($this->url[1]) ? 'Index' : $this->url[1];
		}

		//$this->setParams();

		$this->loadController();

		$this->setAction();

	}

	public function setParams() {

		if(count($this->url) >= 2) {
			$j = 0;
			for($i = 2; $i < count($this->url); $i++) {
				$this->params[$j] = $this->url[$i];
				$j++;
			}
		}
	}

	public function loadController() {

		$controllerPath = APP_DIR . 'controllers/' . $this->controller . '.php';
		if(file_exists($controllerPath)) {
			require $controllerPath;
			$this->controllers = new $this->controller();
		} else {
			require APP_DIR . 'controllers/err.php';
			$error = new Err('Controller file doesn\'t exists: ' . ucfirst($this->controller));
			exit();
			//$error->getMessage('<h1>Controller file doesn\'t exists: ' . $this->controller . '</h1>');
		}
	}

	public function setAction() {

		if(method_exists($this->controllers, $this->method)) {

			$this->controllers->{$this->method}($this->params);

		} else {
			require APP_DIR . 'controllers/err.php';
			$error = new Err('Method doesn\'t exists: ' . ucfirst($this->method));
			exit();
		}
	}
}
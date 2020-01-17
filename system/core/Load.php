<?php

class Load {

	public function __construct() {


	}

	public function view($viewName, $params = null, $main = false) {
		$viewPath = APP_DIR . 'views/' . $viewName . '.php';
		//extract($params, EXTR_PREFIX_SAME, "wddx");
		$viewData = $params;
		if(file_exists($viewPath)) {
			if(!$main) require APP_DIR . 'views/main.php';
			else require $viewPath;
		} else {
			require APP_DIR . 'controllers/err.php';
			$error = new Err('View file doesn\'t exists: ' . ucfirst($viewName));
			exit();
		}
	}

	public function model($modelName) {

		$modelPath = APP_DIR . 'models/' . $modelName . '.php';
		if(file_exists($modelPath)) {
			require $modelPath;
			$modelObject = $modelName . '_Model';
			$modelName = new $modelObject();
			return $modelName;
		} else {
			require APP_DIR . 'controllers/err.php';
			$error = new Err('Model file doesn\'t exists: ' . ucfirst($modelName));
			exit();
		}
	}
}
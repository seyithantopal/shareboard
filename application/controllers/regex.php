<?php

class Regex extends Controller {
	
	public function __construct() {

	}

	public function Index() {
		/*$site = 'https://www.phpr.org/php-ile-regular-expression-regex/';
		$cek = file_get_contents($site);
		preg_match('#<title>(.*?)</title>#', $cek, $baslik);
		echo $baslik[1];*/

		/*$string = 'abcefghijklmnopqrstuvwxyz0123456789';

		preg_match_all("/[a-z^5]/", $string, $matches);

		foreach($matches[0] as $value)
		{
			echo $value;
		}*/

		/*$string = 'user/[@any]';

		$str = 'hello, this is [@firstname], i am [@age] years old';
		preg_match_all('~\[@(.+?)\]~', $str, $matches);
		print_r($matches);*/

		/*$regex = "";
		$new_string = preg_replace('/([a-zA-Z]+) (\d+)/', "$1", "deneme");
		echo $new_string;*/

		$urlm = $_GET['url'];
		$urlm=preg_replace("/[^a-z0-9-]/", "/", $urlm);
		$cachedosyam= APP_DIR . 'cache/'.$urlm.'.html';
		if (file_exists($cachedosyam)) {
			include($cachedosyam);
			exit;
		} else {

			ob_start();
		}
		echo $cachedosyam;
	}
}
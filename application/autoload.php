<?php
function my_autoload ($class) {
	$folders = ['application', 'controllers', 'models', 'views'];
	foreach ($folders as $key => $value) {
		$class = end(explode("\\", $class));
		if(file_exists(__DIR__ . "/../". $value .'/'. $class . ".class.php")) {
			require __DIR__ . "/../". $value .'/'. $class . ".class.php";
		}
	}
}

spl_autoload_register("my_autoload");
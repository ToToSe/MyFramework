<?php
namespace MyFramework;
class DefaultController extends DefaultModel {

	public $layout = 'layout.html';

 	public function defaultAction() {
 		$this->render(['prenom' => $this->getLogin()]);
 	}

 	public function ConnexionAction() {
 		$this->render(['login' => (isset($_POST['login'])) ? $_POST['login'] : '', 'url' =>  $_SERVER['REQUEST_URI']]);
 	}

 	public function FormAction() {
 		$this->render(['url' => $_SERVER['REQUEST_URI'], 'post' => htmlspecialchars(print_r($_POST, true)), 'get' => htmlspecialchars(print_r($_GET, true)), 'server' => htmlspecialchars(print_r($_SERVER, true))]);
 	} 	
}
<?php
namespace MyFramework;
class AuthController extends DefaultModel {

	public $layout = 'layout.html';

 	public function LoginAction() {
 		if(isset($_POST['login']) && isset($_POST['password'])){
 			Auth::login($_POST['login'], $_POST['password'], true);
 		}
 		//exit(var_dump(Auth::User()));
 		//exit(var_dump(Auth::isUser()));
 		//exit(var_dump(Auth::isAdmin()));
 		//exit(var_dump(Auth::Logout()));
 		$this->render(['url' =>  $_SERVER['REQUEST_URI']]);
 	}

 	public function LogoutAction() {
 		$this->render();
 	}
}
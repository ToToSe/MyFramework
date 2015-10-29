<?php
namespace MyFramework;

	class Auth extends Core {
		static public function Login($login, $password, $auth = false) {
			if(isset($_SESSION['user'])){
				return false;
			} else {
				$request = self::$_pdo->query('SELECT * FROM '.self::$user_table.' WHERE username = "'.$login.'" AND password = "'.$password.'"')->fetch(\PDO::FETCH_ASSOC);
				if($request){
					if($auth){
						$_SESSION['user'] = $request;
					}
					return true;
				} else {
					return false;
				}
			}
		}

		static public function User() {
			if(isset($_SESSION['user'])){
				return $_SESSION['user'];
			} else {
				return false;
			}
		}

		static public function isAdmin() {
			if(self::User()[self::$user_column_rank] == 1){
				return true;
			} else {
				return false;
			}
		}

		static public function isUser() {
			if(self::User()[self::$user_column_rank] == 0){
				return true;
			} else {
				return false;
			}
		}

		static public function Logout() {
			if(isset($_SESSION['user'])){
				session_destroy();
				return true;
			} else {
				return false;
			}
		}
	}
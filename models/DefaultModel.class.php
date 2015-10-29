<?php
namespace MyFramework;

class DefaultModel extends Core {
	public function getLogin() {
		return self::$_pdo->query('SELECT * FROM logins WHERE id = 1')->fetch()['login'];
	}
}
<?php
// namespace callmehuyv\helpers;

class Input {
	static function get($key) {
		if (isset($_GET[$key])) {
			return $_GET[$key];
		}
		if (isset($_POST[$key])) {
			return $_POST[$key];
		}
		return null;
	}
	static function has($key) {
		if (Input::get($key) == null) {
			return false;
		}
		return true;
	}
}
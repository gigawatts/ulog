<?php

function isAdmin()
{
	return $_SESSION['role'] === 'admin';
}

function isAuthor($entry)
{
	return isset($_SESSION[$entry]);
}

function login($password)
{
	global $config;
	if(hide($password) === $config['password'])
	{
		$_SESSION['role'] = 'admin';
		return true;
	}
	return false;
}

function trip($name)
{
	$parts = explode('#', $name, 2);
	return $parts[0].(isset($parts[1])? '#' .substr(md5($parts[1]), -5) : '');
}

?>

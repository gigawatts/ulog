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

?>

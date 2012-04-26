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

function trip($name, $id)
{
	if ($name === '')
	{
		return substr($id, -5);
	}
	else
	{
		$parts = explode('#', $name, 2);
		return  $parts[0].(isset($parts[1])? '#' .substr(md5($parts[1]), -5) : '');
	}
}

function quote($reply)
{
	if(isValidEntry('reply', $reply))
	{
		$replyEntry = readEntry('reply', $reply);
		$postEntry = readEntry('post', $replyEntry['post']);
		return '<a class="label label-info" href="view.php/post/' .$replyEntry['post']. '/p/' .onPage($reply, $postEntry['reply']). '#' .$reply. '">' .$replyEntry['trip']. '</a><br />';
	}
	else
	{
		return '<a class="label label-info">[?]</a><br />';
	}
}

?>

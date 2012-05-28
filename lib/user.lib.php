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

function quote($reply)
{
	if(isValidEntry('reply', $reply))
	{
		$replyEntry = readEntry('reply', $reply);
		$postEntry = readEntry('post', $replyEntry['post']);
		return '<a class="label label-info" href="view.php/post/' .$replyEntry['post']. '/p/' .onPage($reply, $postEntry['reply']). '#' .$reply. '">' .$replyEntry['trip']. '</a>';
	}
	else
	{
		return '<a class="label label-info">[?]</a>';
	}
}

?>

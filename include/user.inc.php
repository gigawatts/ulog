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

function permalink($reply)
{
	if(isValidEntry('reply', $reply))
	{
		$replyEntry = readEntry('reply', $reply);
		$postEntry = readEntry('post', $replyEntry['post']);
		return '<a class="quote" href="view.php?post=' .$replyEntry['post']. '&amp;p=' .onPage($reply, $postEntry['reply']). '#' .$reply. '">&gt; ' .$replyEntry['trip']. '</a>';
	}
	else
	{
		return '<a class="quote">&gt; [?]</a>';
	}
}

?>

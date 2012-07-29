<?php

$out['self'] = 'auth';
require 'header.php';

if(isGET('login'))
{
	$out['subtitle'] = $lang['login'];
	if(checkBot() && checkPass('password') && login($_POST['password']))
	{
		session_regenerate_id(true);
		$out['content'] .= '<p><a href="index.php/post">← ' .$lang['redirect']. ' : ' .$lang['post']. '</a></p>';
	}
	else
	{
		$out['content'] .= form('auth.php/login',
			password('password').
			submit());
	}
}
else if(isGET('logout') && isAdmin())
{
	$_SESSION['role'] = '';
	$out['subtitle'] = $lang['logout'];
	$out['content'] .= '<p><a href="index.php/post">← ' .$lang['redirect']. ' : ' .$lang['post']. '</a></p>';
}
else
{
	exit;
}

require 'footer.php';

?>

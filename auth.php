<?php

$template = 'main';
require 'header.php';

if(isGET('login'))
{
	$out['subtitle'] = $lang['login'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	if(checkBot() && check('password') && hide($_POST['password']) === $config['password'])
	{
		$_SESSION['admin'] = true;
		session_regenerate_id(true);
		$out['content'] .= '<p><a href="index.php?post">← ' .$lang['redirect']. ' : ' .$lang['post']. '</a></p>';
	}
	else
	{
		$out['content'] .= '<form action="auth.php?login" method="post">
		<p>' .password(). '</p>
		<p>' .submit(). '</p>
		</form>';
	}
}
else if(isGET('logout') && $_SESSION['admin'])
{
	$_SESSION['admin'] = false;
	$out['subtitle'] = $lang['logout'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>
	<p><a href="index.php?post">← ' .$lang['redirect']. ' : ' .$lang['post']. '</a></p>';
}
else
{
	exit;
}

require 'footer.php';

?>

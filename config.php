<?php

$template = 'main';
require 'header.php';

if(isGET('main') && isAdmin())
{
	$out['subtitle'] = $lang['config'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	if(checkBot() && checkPass() && check('title') &&
		isPOST('theme') && indir($_POST['theme'], 'theme', 'css') &&
		isPOST('lang') && indir($_POST['lang'], 'lang', 'lng.php'))
	{
		$config['password'] = hide($_POST['password']);
		$config['title'] = clean($_POST['title']);
		$config['theme'] = $_POST['theme'];
		$config['lang'] = $_POST['lang'];
		saveEntry('config', 'config', $config);
		$out['content'] .= '<p><a href="index.php?post">← ' .$lang['redirect']. ' : ' .$lang['post']. '</a></p>';
	}
	else
	{
		$themes = fdir('theme');
		$langs = fdir('lang');
		$out['content'] .= '<form action="config.php?main" method="post">
		<p>' .password(). '</p>
		<p>' .text('title', $config['title']). '</p>
		<p>' .select('theme', array_combine($themes, $themes), $config['theme']). ' ' .select('lang', array_combine($langs, $langs), $config['lang']). '</p>
		<p>' .submit(). '</p>
		</form>';
	}
}
else if(isGET('plugin') && isAdmin())
{
	if(function_exists($_GET['plugin']. '_config'))
	{
		$misc = $_GET['plugin']. '_config';
		$out['subtitle'] = $lang['config'].strtolower($_GET['plugin']);
		$out['content'] .= '<h1>' .$out['subtitle']. '</h1>'.
		$misc();
	}
	else
	{
		$out['subtitle'] = $lang['config'].$lang['plugin'];
		$out['content'] .= '<h1>' .$out['subtitle']. '</h1>
		<ul>';
		if($plugins)
		{
			foreach($plugins as $plugin)
			{
				if(function_exists($plugin. '_config'))
				{
					$out['content'] .= '<li><a href="config?plugin=' .$plugin. '">' .$plugin. '</a></li>';
				}
			}
		}
		else
		{
			$out['content'] .= '<li>' .$lang['none']. '</li>';
		}
		$out['content'] .= '</ul>';
	}
}
else
{
	exit;
}

require 'footer.php';

?>

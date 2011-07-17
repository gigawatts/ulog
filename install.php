<?php

require 'include/flatfile.inc.php';

if(!isValidEntry('config', 'config'))
{
	mkdir('data');
	mkdir('data/post');
	mkdir('data/comment');
	mkdir('data/link');
	mkdir('data/category');
	mkdir('data/plugin');
	mkdir('data/config');

	$config['password'] = hide('demo');
	$config['title'] = 'goolog demo';
	$config['theme'] = 'classic';
	$config['lang'] = 'en';
	saveEntry('config', 'config', $config);

	session_start();
	$_SESSION['admin'] = true;
}

header('Location: index.php?post');

?>

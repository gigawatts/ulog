<?php

require 'lib/db.lib.php';
require 'lib/util.lib.php';
require 'lib/HTMLForm.lib.php';

if(!isValidEntry('config', 'config'))
{
	mkdir('data');
	mkdir('data/post');
	mkdir('data/reply');
	mkdir('data/link');
	mkdir('data/category');
	mkdir('data/plugin');
	mkdir('data/config');
	mkdir('data/image');
	touch('.htadmins');

	$config['password'] = hide('demo');
	$config['title'] = 'goolog demo';
	$config['theme'] = 'classic';
	$config['lang'] = 'en';
	saveEntry('config', 'config', $config);

	session_start();
	$_SESSION['role'] = 'admin';
}

redirect('index.php/post');

?>

<?php

if(!isset($template))
{
	exit;
}

require 'include/flatfile.inc.php';

if(!isValidEntry('config', 'config'))
{
	header('Location: install.php');
	exit;
}

session_start();
if(!isset($_SESSION['admin']))
{
	$_SESSION['admin'] = false;
}

//load config
$config = readEntry('config', 'config');

require 'lang/' .$config['lang']. '.lng.php';
require 'include/ui.inc.php';
require 'include/plugin.inc.php';

$plugins = array_map('pathToEntry', fdir('plugin'));

foreach($plugins as $plugin)
{
	require 'plugin/' .$plugin. '.plg.php';
}

$out['content'] = '';
$out['sidebar'] = '';

?>

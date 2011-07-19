<?php

if(!isset($template))
{
	exit;
}
header('Content-Type: text/html; charset=UTF-8');

?>
<!DOCTYPE html>
<html>
<head>
<meta charset = "UTF-8"/>
<meta name = "description" content = "<?php echo $out['subtitle'];?>"/>
<title><?php echo $out['subtitle'];?> - <?php echo $config['title'];?></title>
<link rel = "stylesheet" type = "text/css" href = "theme/<?php echo $config['theme'];?>.thm.css"/>
<link rel = "alternate" type = "application/atom+xml" href = "feed.php?post" title = "<?php echo $lang['post'];?> - <?php echo $config['title'];?>"/>
<link rel = "alternate" type = "application/atom+xml" href = "feed.php?comment" title = "<?php echo $lang['comment'];?> - <?php echo $config['title'];?>"/>
<script src = "http://code.jquery.com/jquery.min.js"></script>
<?php echo hook('body')?>
</head>
<body>
<div id = "container">
<div id = "header"><h2><?php echo $config['title'].hook('header');?></h2></div>
<div id = "menu"><ul>
<li><a href = "index.php?post"><?php echo $lang['post'];?></a></li>
<li><a href = "index.php?comment"><?php echo $lang['comment'];?></a></li>
<li><a href = "search.php"><?php echo $lang['search'];?></a></li>
<li><a href = "index.php?more"><?php echo $lang['more'];?></a></li>
<?php echo hook('menu').
($_SESSION['admin']?
'<li><a href = "config.php">' .$lang['config']. '</a></li>
<li><a href = "auth.php?logout">' .$lang['logout']. '</a></li>' :
'<li><a href = "auth.php?login">' .$lang['login']. '</a></li>');?>
</ul></div>
<div id = "main">
<?php echo $out['content'].hook('main');?>
</div>
<div id = "footer"><ul>
<li><?php echo $lang['poweredBy'];?> <a href = "http://github.com/taylorchu/goolog">goolog</a></li>
<li><a href = "feed.php?post"><?php echo $lang['feed'];?> (<?php echo $lang['post'];?>)</a></li>
<li><a href = "feed.php?comment"><?php echo $lang['feed'];?> (<?php echo $lang['comment'];?>)</a></li>
<?php echo hook('footer');?>
</ul></div>
</div>
</body>
</html>

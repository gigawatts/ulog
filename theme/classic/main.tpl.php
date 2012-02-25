<?php

if(!isset($out))
{
	exit;
}
header('Content-Type: text/html; charset=UTF-8');

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8"/>
	<meta name="description" content="<?php echo $out['subtitle'];?>"/>
	<title><?php echo $out['subtitle'];?> - <?php echo $config['title'];?></title>
	<base href="<?php echo $out['baseURL'];?>"/>
	<link rel="stylesheet" type="text/css" href="http://twitter.github.com/bootstrap/assets/css/bootstrap.css"/>
	<link rel="stylesheet" type="text/css" href="theme/<?php echo $config['theme'];?>/main.css"/>
	<link rel="alternate" type="application/atom+xml" href="feed.php/post" title="<?php echo $lang['post'];?> - <?php echo $config['title'];?>"/>
	<link rel="alternate" type="application/atom+xml" href="feed.php/reply" title="<?php echo $lang['reply'];?> - <?php echo $config['title'];?>"/>
	<script src="http://code.jquery.com/jquery.min.js"></script>
	<script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-tooltip.js"></script>
	<script src="http://twitter.github.com/bootstrap/assets/js/bootstrap-popover.js"></script>
	<?php echo hook('head', $out['self']);?>
</head>
<body>
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container">
				<a class="brand" href="#"><?php echo $config['title'];?></a>
				<ul class="nav">
				<li><a href="index.php/post"><?php echo $lang['post'];?></a></li>
				<li><a href="index.php/reply"><?php echo $lang['reply'];?></a></li>
				<li><a href="search.php"><?php echo $lang['search'];?></a></li>
				<?php echo hook('menu', $out['self']).
				(isAdmin()?
				'<li><a href="config.php/main">' .$lang['config']. '</a></li>
				<li><a href="config.php/plugin">' .$lang['plugin']. '</a></li>
				<li><a href="auth.php/logout">' .$lang['logout']. '</a></li>' :
				'<li><a href="auth.php/login">' .$lang['login']. '</a></li>');?>
				</ul>
			</div>
		</div>
	</div>
	<div class="container">
		<?php echo hook('beforeMain', $out['self']);?>
		<div class="row">
			<div id="main" class="span8">
				<div class="page-header"><h1><?php echo $out['sub_prefix'].$out['subtitle'];?></h1></div>
				<?php echo $out['content'];?>
			</div>
			<div id="sidebar" class="offset1 span3"><?php echo $out['sidebar'].hook('sidebar', $out['self']);?></div>
		</div>
		<?php echo hook('afterMain', $out['self']);?>
		<div id="footer">
			<span><?php echo $lang['poweredBy'];?> <a href="http://github.com/taylorchu/goolog">goolog</a></span>
			<span><a href="feed.php/post"><?php echo $lang['feed'];?> (<?php echo $lang['post'];?>)</a></span>
			<span><a href="feed.php/reply"><?php echo $lang['feed'];?> (<?php echo $lang['reply'];?>)</a></span>
			<?php echo hook('footer', $out['self']);?>
		</div>
	</div>
</body>
</html>

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
	<meta name="description" content="<?php echo $out['subtitle']?>"/>
	<title><?php echo $config['title']?> - <?php echo $out['subtitle']?></title>
	<base href="<?php echo $out['baseURL']?>"/>
	<link rel="stylesheet" type="text/css" href="theme/classic/bootstrap.css"/>
	<link rel="stylesheet" type="text/css" href="theme/<?php echo $config['theme']?>/main.css"/>
	<link rel="alternate" type="application/atom+xml" href="feed.php/post" title="<?php echo $lang['post']?> - <?php echo $config['title']?>"/>
	<link rel="alternate" type="application/atom+xml" href="feed.php/reply" title="<?php echo $lang['reply']?> - <?php echo $config['title']?>"/>
	<script src="theme/classic/jquery.min.js"></script>
	<script src="theme/classic/jquery.form.js"></script>
	<script src="theme/classic/bootstrap-tooltip.js"></script>
	<script src="theme/classic/bootstrap-popover.js"></script>
	<script src="theme/classic/prettify.js"></script>
	<link rel="stylesheet" type="text/css" href="theme/classic/prettify.css"/>
	<script type="text/javascript" >
	 $(document).ready(function() { 
      	     $('#photoimg').live('change', function(){ 
		$("#preview").html('');
		$("#preview").html('<img src="theme/classic/img/loader.gif" alt="Uploading...."/>');
	 	  $("#imageform").ajaxForm({target: '#preview'}).submit();
		});
       	 }); 
</script>
	<script>$(function () { prettyPrint(); })</script>
	<?php echo hook('head', $out['self'])?>
</head>
<body>
	<div class="navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<a class="brand"><font color="#ff7920"><?php echo $config['title']?></font></a>
				<ul class="nav">
				<li><a href="index.php/post"><?php echo $lang['post']?></a></li>
				<li><a href="index.php/reply"><?php echo $lang['reply']?></a></li>
				<li><a href="search.php"><?php echo $lang['search']?></a></li>
				<?php echo hook('menu', $out['self']).
				(isAdmin()?
				'<li><a>User ID: <b>' . $_SERVER['REMOTE_USER'] . '</b> [Admin]</a></li>' :
                                '<li><a>User ID: <b>' . $_SERVER['REMOTE_USER'] . '</b></a></li>')?>
				</ul>
			</div>
		</div>
	</div>
	<div class="container">
		<?php echo hook('beforeMain', $out['self'])?>
		<div class="row">
			<div id="main" class="span8">
				<div class="page-header"><h1><?php echo $out['sub_prefix'].$out['subtitle']?></h1></div>
								<?php echo $out['content']?>
			</div>
			<div id="sidebar" class="offset1 span3"><?php echo $out['sidebar'].hook('sidebar', $out['self'])?></div>
		</div>
		<?php echo hook('afterMain', $out['self'])?>
		<div id="footer">
			<span><?php echo $lang['poweredBy']?> <a href="http://github.com/taylorchu/goolog">goolog</a></span>
			<span><a href="feed.php/post"><?php echo $lang['feed']?> (<?php echo $lang['post']?>)</a></span>
			<span><a href="feed.php/reply"><?php echo $lang['feed']?> (<?php echo $lang['reply']?>)</a></span>
			<?php echo hook('footer', $out['self'])?>
		</div>
	</div>
</body>
</html>

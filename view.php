<?php

$out['self'] = 'view';
require 'header.php';
require 'include/manage.inc.php';

if(isGET('post') && isValidEntry('post', $_GET['post']))
{
	require 'include/parser.inc.php';
	require 'include/page.inc.php';
	$postEntry = readEntry('post', $_GET['post']);

	$postEntry['view']++;
	saveEntry('post', $_GET['post'], $postEntry);

	$out['subtitle'] = $postEntry['title'];
	$out['content'] .= '<div class="post">
	<div class="title"><h1>' .managePost($_GET['post']).$out['subtitle']. '</h1></div>
	<div class="content">' .content($postEntry['content']). '</div>'.
	(!$postEntry['locked']? '<p><a class="btn" href="add.php/reply/' .$_GET['post']. '">' .$lang['add'].$lang['reply']. '</a></p>' : '').
	hook('afterPost', $_GET['post']).
	'<div>';
	if($postEntry['category'] !== '')
	{
		$categoryEntry = readEntry('category', $postEntry['category']);
		$out['content'] .= '<a class="label" href="view.php/category/' .$postEntry['category']. '">' .$categoryEntry['name']. '</a>';
	}
	$out['content'] .= ($postEntry['reply']? '<a class="label" href="#">' .$lang['reply']. ' (' .count($postEntry['reply']). ')</a>' : '').
	'<a class="label" href="#">' .$lang['view']. ' (' .shortNum($postEntry['view']). ')</a>
	<a class="label" href="#">' .toDate($_GET['post']). '</a>
	</div>
	</div>';
	$total = totalPage($postEntry['reply']);
	$p = pid($total);
	if($postEntry['reply'])
	{
		foreach(viewPage($postEntry['reply'], $p) as $reply)
		{
			$replyEntry = readEntry('reply', $reply);
			$out['content'] .= '<div id="' .$reply. '" class="reply">
			<div class="title">' .manageReply($reply).$replyEntry['trip']. ' - ' .toDate($reply). '</div>
			<div class="content">' .content($replyEntry['content']). '</div>'.
			(!$postEntry['locked']? '<p><a class="btn" href="add.php/reply/' .$_GET['post']. '/q/' .$reply. '">' .$lang['add'].$lang['reply']. '</a></p>' : '').
			hook('afterReply', $reply).
			'</div>';
		}
	}
	$out['content'] .= pageControl($p, $total, 'view.php/post/' .$_GET['post']);
}
else if(isGET('category') && isValidEntry('category', $_GET['category']))
{
	$categoryEntry = readEntry('category', $_GET['category']);
	$out['subtitle'] = $categoryEntry['name'];
	$out['content'] .= '<h1>' .manageCategory($_GET['category']).$out['subtitle']. '</h1>
	<ul>';
	if($categoryEntry['post'])
	{
		foreach($categoryEntry['post'] as $post)
		{
			$postEntry = readEntry('post', $post);
			$out['content'] .= '<li>' .managePost($post). '<a href="view.php/post/' .$post. '">' .$postEntry['title']. '</a> - ' .toDate($post). '</li>';
		}
	}
	else
	{
		$out['content'] .= '<li>' .$lang['none']. '</li>';
	}
	$out['content'] .= '</ul>';
}
else if(isGET('archive') && strlen($_GET['archive']) === 4)
{
	$archivedPosts = array();
	$posts = listEntry('post');
	sort($posts);
	foreach($posts as $post)
	{
		if($_GET['archive'] === substr($post, 0, 4))
		{
			$month = substr($post, 5, 2);
			$archivedPosts[$month][] = $post;
		}
	}
	if(!$archivedPosts)
	{
		exit;
	}
	$monthStr = array(
		'01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'May', '06' => 'Jun',
		'07' => 'Jul', '08' => 'Aug', '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec'
	);
	$out['subtitle'] = $_GET['archive'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	foreach($archivedPosts as $month => $monthPosts)
	{
		$out['content'] .= '<b>' .$monthStr[$month]. '</b>
		<ul>';
		foreach($monthPosts as $post)
		{
			$postEntry = readEntry('post', $post);
			$out['content'] .= '<li>' .managePost($post). '<a href="view.php/post/' .$post. '">' .$postEntry['title']. '</a> - ' .toDate($post). '</li>';
		}
		$out['content'] .= '</ul>';
	}
}
else if(isGET('plugin') && function_exists($_GET['plugin']. '_view'))
{
	$misc = $_GET['plugin']. '_view';
	$out['subtitle'] = strtolower($_GET['plugin']);
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>'.
	$misc();
}
else
{
	redirect('index.php/404');
}

require 'footer.php';

?>

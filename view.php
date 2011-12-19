<?php

$template = 'main';
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
	(!$postEntry['locked']? '<p><a class="button" href="add.php/reply/' .$_GET['post']. '">' .$lang['add'].$lang['reply']. '</a></p>' : '').
	hook('afterPost', $_GET['post']).
	'<div class="meta"><ul>';
	if($postEntry['category'] !== '')
	{
		$categoryEntry = readEntry('category', $postEntry['category']);
		$out['content'] .= '<li><a href="view.php/category/' .$postEntry['category']. '">' .$categoryEntry['name']. '</a></li>';
	}
	$out['content'] .= ($postEntry['reply']? '<li>' .$lang['reply']. ' (' .count($postEntry['reply']). ')</li>' : '').
	'<li>' .$lang['view']. ' (' .shortNum($postEntry['view']). ')</li>
	<li>' .toDate($_GET['post']). '</li>
	</ul></div>
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
			(!$postEntry['locked']? '<p><a class="button" href="add.php/reply/' .$_GET['post']. '/q/' .$reply. '">' .$lang['add'].$lang['reply']. '</a></p>' : '').
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
else if(isGET('archive') && strlen($_GET['archive']) === 7)
{
	$archivedPosts = array();
	foreach(listEntry('post') as $post)
	{
		if($_GET['archive'] === substr($post, 0, 7))
		{
			$archivedPosts[] = $post;
		}
	}
	if(!$archivedPosts)
	{
		exit;
	}
	$out['subtitle'] = date('M Y', strtotime($_GET['archive']));
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>
	<ul>';
	foreach($archivedPosts as $post)
	{
		$postEntry = readEntry('post', $post);
		$out['content'] .= '<li>' .managePost($post). '<a href="view.php/post/' .$post. '">' .$postEntry['title']. '</a> - ' .toDate($post). '</li>';
	}
	$out['content'] .= '</ul>';
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

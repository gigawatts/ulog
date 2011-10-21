<?php

$template = 'main';
require 'header.php';
require 'include/manage.inc.php';

if(isGET('post') && isValidEntry('post', $_GET['post']))
{
	require 'include/parser.inc.php';
	$postEntry = readEntry('post', $_GET['post']);

	$postEntry['view']++;
	saveEntry('post', $_GET['post'], $postEntry);

	$out['subtitle'] = $postEntry['title'];
	$out['content'] .= '<div class="entryContainer">
	<div class="entryHeader"><h1>' .managePost($_GET['post']).$out['subtitle']. '</h1></div>
	<div class="entryMain">
	<p>' .content($postEntry['content']). '</p>'.
	(!$postEntry['locked']? '<p><a class="important" href="add.php?comment=' .$_GET['post']. '">' .$lang['add'].$lang['comment']. '</a></p>' : '').
	hook('afterPost', $_GET['post']).
	'</div>
	<div class="entryFooter"><ul>';
	if($postEntry['category'] !== '')
	{
		$categoryEntry = readEntry('category', $postEntry['category']);
		$out['content'] .= '<li><a href="view.php?category=' .$postEntry['category']. '">' .$categoryEntry['name']. '</a></li>';
	}
	$out['content'] .= ($postEntry['comment']? '<li>' .$lang['comment']. ' (' .count($postEntry['comment']). ')</li>' : '').
	'<li>' .$lang['view']. ' (' .$postEntry['view']. ')</li>
	<li>' .entryDate($_GET['post']). '</li>
	</ul></div>
	</div>';
	foreach($postEntry['comment'] as $comment)
	{
		$commentEntry = readEntry('comment', $comment);
		$out['content'] .= '<div id="' .$comment. '" class="entryContainer">
		<div class="entryHeader">' .manageComment($comment).substr($comment, -7, 7). '</div>
		<div class="entryMain">
		<p>' .content($commentEntry['content']). '</p>'.
		hook('afterComment', $comment).
		'</div>
		<div class="entryFooter"><ul><li>' .entryDate($comment). '</li></ul></div>
		</div>';
	}
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
			$out['content'] .= '<li>' .managePost($post). '<a href="view.php?post=' .$post. '">' .$postEntry['title']. '</a> - ' .entryDate($post). '</li>';
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
	$posts = listEntry('post');
	$archivedPosts = array();
	foreach($posts as $post)
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
	$out['subtitle'] = date('F Y', strtotime($_GET['archive']));
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>
	<ul>';
	foreach($archivedPosts as $post)
	{
		$postEntry = readEntry('post', $post);
		$out['content'] .= '<li>' .managePost($post). '<a href="view.php?post=' .$post. '">' .$postEntry['title']. '</a> - ' .entryDate($post). '</li>';
	}
	$out['content'] .= '</ul>';
}
else
{
	exit;
}

require 'footer.php';

?>

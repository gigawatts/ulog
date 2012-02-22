<?php

$out['self'] = 'delete';
require 'header.php';

if(isGET('post') && isAdmin() && isValidEntry('post', $_GET['post']))
{
	$postEntry = readEntry('post', $_GET['post']);
	$out['subtitle'] = $lang['delete'].$lang['post']. ' : ' .$postEntry['title'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	if(checkBot())
	{
		deleteEntry('post', $_GET['post']);
		if($postEntry['category'] !== '')
		{
			$categoryEntry = readEntry('category', $postEntry['category']);
			unset($categoryEntry['post'][$_GET['post']]);
			saveEntry('category', $postEntry['category'], $categoryEntry);
		}
		foreach($postEntry['reply'] as $reply)
		{
			deleteEntry('reply', $reply);
		}
		$out['content'] .= '<p><a href="index.php/post">← ' .$lang['redirect']. ' : ' .$lang['post']. '</a></p>';
	}
	else
	{
		$out['content'] .= form('delete.php/post/' .$_GET['post'],
			submit());
	}
}
else if(isGET('reply') && (isAdmin() || isAuthor($_GET['reply'])) && isValidEntry('reply', $_GET['reply']))
{
	$replyEntry = readEntry('reply', $_GET['reply']);
	$out['subtitle'] = $lang['delete'].$lang['reply'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	if(checkBot())
	{
		deleteEntry('reply', $_GET['reply']);

		$postEntry = readEntry('post', $replyEntry['post']);
		unset($postEntry['reply'][$_GET['reply']]);
		saveEntry('post', $replyEntry['post'], $postEntry);
		$out['content'] .= '<p><a href="view.php/post/' .$replyEntry['post']. '">← ' .$lang['redirect']. ' : ' .$postEntry['title']. '</a></p>';
	}
	else
	{
		$out['content'] .= form('delete.php/reply/' .$_GET['reply'],
			submit());
	}
}
else if(isGET('link') && isAdmin() && isValidEntry('link', $_GET['link']))
{
	$linkEntry = readEntry('link', $_GET['link']);
	$out['subtitle'] = $lang['delete'].$lang['link']. ' : ' .$linkEntry['name'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	if(checkBot())
	{
		deleteEntry('link', $_GET['link']);
		$out['content'] .= '<p><a href="index.php/post">← ' .$lang['redirect']. ' : ' .$lang['post']. '</a></p>';
	}
	else
	{
		$out['content'] .= form('delete.php/link/' .$_GET['link'],
			submit());
	}
}
else if(isGET('category') && isAdmin() && isValidEntry('category', $_GET['category']))
{
	$categoryEntry = readEntry('category', $_GET['category']);
	$out['subtitle'] = $lang['delete'].$lang['category']. ' : ' .$categoryEntry['name'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	if(checkBot())
	{
		deleteEntry('category', $_GET['category']);
		foreach($categoryEntry['post'] as $post)
		{
			$postEntry = readEntry('post', $post);
			$postEntry['category'] = '';
			saveEntry('post', $post, $postEntry);
		}
		$out['content'] .= '<p><a href="index.php/post">← ' .$lang['redirect']. ' : ' .$lang['post']. '</a></p>';
	}
	else
	{
		$out['content'] .= form('delete.php/category/' .$_GET['category'],
			submit());
	}
}
else
{
	exit;
}

require 'footer.php';

?>

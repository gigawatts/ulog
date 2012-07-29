<?php

$out['self'] = 'delete';
require 'header.php';

if(isGETValidEntry('post', 'post') && isAdmin())
{
	$postEntry = readEntry('post', $_GET['post']);
	$out['subtitle'] = lang('delete post : %s', $postEntry['title']);
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
else if(isGETValidEntry('reply', 'reply') && (isAdmin() || isAuthor($_GET['reply'])))
{
	$replyEntry = readEntry('reply', $_GET['reply']);
	$out['subtitle'] = lang('delete reply');
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
else if(isGETValidEntry('link', 'link') && isAdmin())
{
	$linkEntry = readEntry('link', $_GET['link']);
	$out['subtitle'] = lang('delete link : %s', $linkEntry['name']);
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
else if(isGETValidEntry('category', 'category') && isAdmin())
{
	$categoryEntry = readEntry('category', $_GET['category']);
	$out['subtitle'] = lang('delete category : %s', $categoryEntry['name']);
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

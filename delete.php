<?php

$template = 'main';
require 'header.php';

if(isGET('post') && $_SESSION['admin'] && isValidEntry('post', $_GET['post']))
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
		foreach($postEntry['comment'] as $comment)
		{
			deleteEntry('comment', $comment);
		}
		$out['content'] .= '<p><a href="index.php?post">← ' .$lang['redirect']. ' : ' .$lang['post']. '</a></p>';
	}
	else
	{
		$out['content'] .= '<form action="delete.php?post=' .$_GET['post']. '" method="post">
		<p>' .submit(). '</p>
		</form>';
	}
}
else if(isGET('comment') && $_SESSION['admin'] && isValidEntry('comment', $_GET['comment']))
{
	$commentEntry = readEntry('comment', $_GET['comment']);
	$out['subtitle'] = $lang['delete'].$lang['comment'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	if(checkBot())
	{
		deleteEntry('comment', $_GET['comment']);

		$postEntry = readEntry('post', $commentEntry['post']);
		unset($postEntry['comment'][$_GET['comment']]);
		saveEntry('post', $commentEntry['post'], $postEntry);
		$out['content'] .= '<p><a href="view.php?post=' .$commentEntry['post']. '">← ' .$lang['redirect']. ' : ' .$postEntry['title']. '</a></p>';
	}
	else
	{
		$out['content'] .= '<form action="delete.php?comment=' .$_GET['comment']. '" method="post">
		<p>' .submit(). '</p>
		</form>';
	}
}
else if(isGET('link') && $_SESSION['admin'] && isValidEntry('link', $_GET['link']))
{
	$linkEntry = readEntry('link', $_GET['link']);
	$out['subtitle'] = $lang['delete'].$lang['link']. ' : ' .$linkEntry['name'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	if(checkBot())
	{
		deleteEntry('link', $_GET['link']);
		$out['content'] .= '<p><a href="index.php?post">← ' .$lang['redirect']. ' : ' .$lang['post']. '</a></p>';
	}
	else
	{
		$out['content'] .= '<form action="delete.php?link=' .$_GET['link']. '" method="post">
		<p>' .submit(). '</p>
		</form>';
	}
}
else if(isGET('category') && $_SESSION['admin'] && isValidEntry('category', $_GET['category']))
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
		$out['content'] .= '<p><a href="index.php?post">← ' .$lang['redirect']. ' : ' .$lang['post']. '</a></p>';
	}
	else
	{
		$out['content'] .= '<form action="delete.php?category=' .$_GET['category']. '" method="post">
		<p>' .submit(). '</p>
		</form>';
	}
}
else
{
	exit;
}

require 'footer.php';

?>

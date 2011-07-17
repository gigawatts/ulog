<?php

$template = 'main';
require 'header.php';
require 'include/manage.inc.php';
require 'include/parser.inc.php';

if(isGET('post'))
{
	$out['subtitle'] = $lang['post'];
	$out['content'] .= '<h1>' .($_SESSION['admin']? '<a href = "add.php?post">[' .$lang['add']. ']</a>' : '').$out['subtitle']. '</h1>';
	$posts = listEntry('post');
	rsort($posts);
	$page = array_chunk($posts, 4);
	if(!isset($page[$_GET['post']-1]))
	{
		$_GET['post'] = 1;
	}
	$i = $_GET['post'] - 1;
	if($page)
	{
		foreach($page[$i] as $post)
		{
			$postEntry = readEntry('post', $post);
			$out['content'] .= '<div class = "entryContainer">
			<div class = "entryHeader">' .managePost($post).$postEntry['title']. '</div>
			<div class = "entryMain">
			<p>' .summary($postEntry['content']). '</p>
			<p><a class = "important" href = "view.php?post=' .$post. '">' .$lang['more']. '</a></p>
			</div>
			<div class = "entryFooter"><ul>';
			if($postEntry['category'] === '')
			{
				$out['content'] .= '<li>' .$lang['uncategorized']. '</li>';
			}
			else
			{
				$categoryEntry = readEntry('category', $postEntry['category']);
				$out['content'] .= '<li><a href = "view.php?category=' .$postEntry['category']. '">' .$categoryEntry['name']. '</a></li>';
			}
			$out['content'] .= ($postEntry['comment']? '<li>' .$lang['comment']. ' (' .count($postEntry['comment']). ')</li>' : '').
			'<li>' .$lang['view']. ' (' .$postEntry['view']. ')</li>
			<li>' .entryDate($post). '</li>
			</ul></div>
			</div>';
		}
	}
	else
	{
		$out['content'] .= '<p>' .$lang['none']. '</p>';
	}
	$out['content'] .= '<div id = "page"><ul>' .
	(isset($page[$i-1])? '<li><a href = "index.php?post=' .($_GET['post']-1). '">← ' .$lang['prev']. '</a></li>' : '').
	'<li>' .$lang['page']. ' : ' .$_GET['post']. ' / ' .count($page). '</li>' .
	(isset($page[$i+1])? '<li><a href = "index.php?post=' .($_GET['post']+1). '">' .$lang['next']. ' →</a></li>' : '').
	'</ul></div>';
}
else if(isGET('comment'))
{
	$out['subtitle'] = $lang['comment'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	$comments = listEntry('comment');
	rsort($comments);
	$page = array_chunk($comments, 4);
	if(!isset($page[$_GET['comment']-1]))
	{
		$_GET['comment'] = 1;
	}
	$i = $_GET['comment'] - 1;
	if($page)
	{
		foreach($page[$i] as $comment)
		{
			$commentEntry = readEntry('comment', $comment);
			$postEntry = readEntry('post', $commentEntry['post']);
			$out['content'] .= '<div class = "entryContainer">
			<div class = "entryHeader">' .manageComment($comment).$commentEntry['author']. '@' .$postEntry['title']. '</div>
			<div class = "entryMain">
			<p>' .summary($commentEntry['content']). '</p>
			<p><a class = "important" href = "view.php?post=' .$commentEntry['post']. '">' .$lang['more']. '</a></p>
			</div>
			<div class = "entryFooter"><ul><li>' .entryDate($comment). '</li></ul></div>
			</div>';

		}
	}
	else
	{
		$out['content'] .= '<p>' .$lang['none']. '</p>';
	}
	$out['content'] .= '<div id = "page"><ul>' .
	(isset($page[$i-1])? '<li><a href = "index.php?comment=' .($_GET['comment']-1). '">← ' .$lang['prev']. '</a></li>' : '').
	'<li>' .$lang['page']. ' : ' .$_GET['comment']. ' / ' .count($page). '</li>' .
	(isset($page[$i+1])? '<li><a href = "index.php?comment=' .($_GET['comment']+1). '">' .$lang['next']. ' →</a></li>' : '').
	'</ul></div>';
}
else if(isGET('more'))
{
	$out['subtitle'] = $lang['more'];

	//link
	$out['content'] .= '<h1>' .($_SESSION['admin']? '<a href = "add.php?link">[' .$lang['add']. ']</a>' : '').$lang['link']. '</h1>
	<ul>';
	$links = listEntry('link');
	if($links)
	{
		foreach($links as $link)
		{
			$linkEntry = readEntry('link', $link);
			$out['content'] .= '<li>' .manageLink($link). '<a href = "' .$linkEntry['url']. '">' .$linkEntry['name']. '</a></li>';
		}
	}
	else
	{
		$out['content'] .= '<li>' .$lang['none']. '</li>';
	}
	$out['content'] .= '</ul>';

	//category
	$out['content'] .= '<h1>' .($_SESSION['admin']? '<a href = "add.php?category">[' .$lang['add']. ']</a>' : '').$lang['category']. '</h1>
	<ul>';
	$categories = listEntry('category');
	if($categories)
	{
		foreach($categories as $category)
		{
			$categoryEntry = readEntry('category', $category);
			$out['content'] .= '<li>' .manageCategory($category). '<a href = "view.php?category=' .$category. '">' .$categoryEntry['name']. ' (' .count($categoryEntry['post']). ')</a></li>';
		}
	}
	else
	{
		$out['content'] .= '<li>' .$lang['none']. '</li>';
	}
	$out['content'] .= '</ul>';

	//archive
	$posts = listEntry('post');
	$archives = array();
	foreach($posts as $post)
	{
		$archive = substr($post, 0, 7);
		if(isset($archives[$archive]))
		{
			$archives[$archive]++;
		}
		else
		{
			$archives[$archive] = 1;
		}
	}

	$out['content'] .= '<h1>' .$lang['archive']. '</h1>
	<ul>';
	if($archives)
	{
		foreach($archives as $archive => $count)
		{
			$out['content'] .= '<li><a href = "view.php?archive=' .$archive. '">' .date('F Y', strtotime($archive)). ' (' .$count. ')</a></li>';
		}
	}
	else
	{
		$out['content'] .= '<li>' .$lang['none']. '</li>';
	}
	$out['content'] .= '</ul>';
}
else
{
	header('Location: index.php?post');
	exit;
}

require 'footer.php';

?>

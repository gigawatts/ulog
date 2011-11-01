<?php

$template = 'main';
require 'header.php';
require 'include/manage.inc.php';
require 'include/parser.inc.php';

if(isGET('post'))
{
	$out['subtitle'] = $lang['post'];
	$out['content'] .= '<h1>' .(isAdmin()? '<a href="add.php?post">[+]</a>' : '').$out['subtitle']. '</h1>';
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
			$out['content'] .= '<div class="entryContainer">
			<div class="entryHeader">' .managePost($post).$postEntry['title']. '</div>
			<div class="entryMain">
			<p>' .summary($postEntry['content']). '</p>
			<p><a class="important" href="view.php?post=' .$post. '">' .$lang['more']. '</a></p>
			</div>
			<div class="entryFooter"><ul>';
			if($postEntry['category'] !== '')
			{
				$categoryEntry = readEntry('category', $postEntry['category']);
				$out['content'] .= '<li><a href="view.php?category=' .$postEntry['category']. '">' .$categoryEntry['name']. '</a></li>';
			}
			$out['content'] .= ($postEntry['comment']? '<li>' .$lang['comment']. ' (' .count($postEntry['comment']). ')</li>' : '').
			($postEntry['locked']? '<li>' .$lang['locked']. '</li>' : '').
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
	$out['content'] .= '<div id="page"><ul>' .
	(isset($page[$i-1])? '<li><a href="index.php?post=' .($_GET['post']-1). '">← ' .$lang['prev']. '</a></li>' : '').
	'<li>' .$lang['page']. ' : ' .$_GET['post']. ' / ' .count($page). '</li>' .
	(isset($page[$i+1])? '<li><a href="index.php?post=' .($_GET['post']+1). '">' .$lang['next']. ' →</a></li>' : '').
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
			$out['content'] .= '<div class="entryContainer">
			<div class="entryHeader">' .manageComment($comment).$commentEntry['trip']. ' - ' .$postEntry['title']. '</div>
			<div class="entryMain">
			<p>' .summary($commentEntry['content']). '</p>
			<p><a class="important" href="view.php?post=' .$commentEntry['post']. '#' .$comment. '">' .$lang['more']. '</a></p>
			</div>
			<div class="entryFooter"><ul><li>' .entryDate($comment). '</li></ul></div>
			</div>';

		}
	}
	else
	{
		$out['content'] .= '<p>' .$lang['none']. '</p>';
	}
	$out['content'] .= '<div id="page"><ul>' .
	(isset($page[$i-1])? '<li><a href="index.php?comment=' .($_GET['comment']-1). '">← ' .$lang['prev']. '</a></li>' : '').
	'<li>' .$lang['page']. ' : ' .$_GET['comment']. ' / ' .count($page). '</li>' .
	(isset($page[$i+1])? '<li><a href="index.php?comment=' .($_GET['comment']+1). '">' .$lang['next']. ' →</a></li>' : '').
	'</ul></div>';
}
else
{
	header('Location: index.php?post');
	exit;
}

require 'footer.php';

?>

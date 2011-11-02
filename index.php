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
			$out['content'] .= ($postEntry['reply']? '<li>' .$lang['reply']. ' (' .count($postEntry['reply']). ')</li>' : '').
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
else if(isGET('reply'))
{
	$out['subtitle'] = $lang['reply'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	$replies = listEntry('reply');
	rsort($replies);
	$page = array_chunk($replies, 4);
	if(!isset($page[$_GET['reply']-1]))
	{
		$_GET['reply'] = 1;
	}
	$i = $_GET['reply'] - 1;
	if($page)
	{
		foreach($page[$i] as $reply)
		{
			$replyEntry = readEntry('reply', $reply);
			$postEntry = readEntry('post', $replyEntry['post']);
			$out['content'] .= '<div class="entryContainer">
			<div class="entryHeader">' .manageComment($reply).$replyEntry['trip']. ' - ' .$postEntry['title']. '</div>
			<div class="entryMain">
			<p>' .summary($replyEntry['content']). '</p>
			<p><a class="important" href="view.php?post=' .$replyEntry['post']. '#' .$reply. '">' .$lang['more']. '</a></p>
			</div>
			<div class="entryFooter"><ul><li>' .entryDate($reply). '</li></ul></div>
			</div>';

		}
	}
	else
	{
		$out['content'] .= '<p>' .$lang['none']. '</p>';
	}
	$out['content'] .= '<div id="page"><ul>' .
	(isset($page[$i-1])? '<li><a href="index.php?reply=' .($_GET['reply']-1). '">← ' .$lang['prev']. '</a></li>' : '').
	'<li>' .$lang['page']. ' : ' .$_GET['reply']. ' / ' .count($page). '</li>' .
	(isset($page[$i+1])? '<li><a href="index.php?reply=' .($_GET['reply']+1). '">' .$lang['next']. ' →</a></li>' : '').
	'</ul></div>';
}
else
{
	header('Location: index.php?post');
	exit;
}

require 'footer.php';

?>

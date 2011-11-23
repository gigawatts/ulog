<?php

$template = 'main';
require 'header.php';
require 'include/manage.inc.php';
require 'include/parser.inc.php';
require 'include/page.inc.php';

if(isGET('post'))
{
	$out['subtitle'] = $lang['post'];
	$out['content'] .= '<h1>' .(isAdmin()? '<a href="add.php?post">[+]</a>' : '').$out['subtitle']. '</h1>';
	$posts = listEntry('post');
	rsort($posts);
	$total = countPage($posts);
	$p = pageNum($total);
	if($total > 0)
	{
		foreach(getPage($posts, $p) as $post)
		{
			$postEntry = readEntry('post', $post);
			$out['content'] .= '<div class="entryContainer">
			<div class="entryHeader">' .managePost($post).$postEntry['title']. '</div>
			<div class="entryMain">
			<p>' .summary($postEntry['contentHTML']). '</p>
			<p><a class="button" href="view.php?post=' .$post. '">' .$lang['more']. '</a></p>
			</div>
			<div class="entryFooter"><ul>';
			if($postEntry['category'] !== '')
			{
				$categoryEntry = readEntry('category', $postEntry['category']);
				$out['content'] .= '<li><a href="view.php?category=' .$postEntry['category']. '">' .$categoryEntry['name']. '</a></li>';
			}
			$out['content'] .= ($postEntry['reply']? '<li>' .$lang['reply']. ' (' .count($postEntry['reply']). ')</li>' : '').
			($postEntry['locked']? '<li>' .$lang['locked']. '</li>' : '').
			'<li>' .$lang['view']. ' (' .shortNum($postEntry['view']). ')</li>
			<li>' .entryDate($post). '</li>
			</ul></div>
			</div>';
		}
	}
	else
	{
		$out['content'] .= '<p>' .$lang['none']. '</p>';
	}
	$out['content'] .= pageControl($p, $total, 'post');
}
else if(isGET('reply'))
{
	$out['subtitle'] = $lang['reply'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	$replies = listEntry('reply');
	rsort($replies);
	$total = countPage($replies);
	$p = pageNum($total);
	if($total > 0)
	{
		foreach(getPage($replies, $p) as $reply)
		{
			$replyEntry = readEntry('reply', $reply);
			$postEntry = readEntry('post', $replyEntry['post']);
			$out['content'] .= '<div class="entryContainer">
			<div class="entryHeader">' .manageReply($reply).$replyEntry['trip']. ' ' .$lang['replied']. ' ' .$postEntry['title']. '</div>
			<div class="entryMain">
			<p>' .summary($replyEntry['contentHTML']). '</p>
			<p><a class="button" href="view.php?post=' .$replyEntry['post']. '&amp;p=' .onPage($reply, $postEntry['reply']). '#' .$reply. '">' .$lang['more']. '</a></p>
			</div>
			<div class="entryFooter"><ul><li>' .entryDate($reply). '</li></ul></div>
			</div>';
		}
	}
	else
	{
		$out['content'] .= '<p>' .$lang['none']. '</p>';
	}
	$out['content'] .= pageControl($p, $total, 'reply');
}
else
{
	header('Location: index.php?post');
	exit;
}

require 'footer.php';

?>

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
	$pages = array_chunk($posts, 4);
	$total = count($pages);
	$p = pageNum($total);
	if($total > 0)
	{
		foreach($pages[$p-1] as $post)
		{
			$postEntry = readEntry('post', $post);
			$out['content'] .= '<div class="entryContainer">
			<div class="entryHeader">' .managePost($post).$postEntry['title']. '</div>
			<div class="entryMain">
			<div>' .summary($postEntry['content']). '</div>
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
	$out['content'] .= pageControl($p, $total, 'post');
}
else if(isGET('reply'))
{
	$out['subtitle'] = $lang['reply'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	$replies = listEntry('reply');
	rsort($replies);
	$pages = array_chunk($replies, 4);
	$total = count($pages);
	$p = pageNum($total);
	if($total > 0)
	{
		foreach($pages[$p-1] as $reply)
		{
			$replyEntry = readEntry('reply', $reply);
			$postEntry = readEntry('post', $replyEntry['post']);
			$out['content'] .= '<div class="entryContainer">
			<div class="entryHeader">' .manageReply($reply).$replyEntry['trip']. ' ' .$lang['replied']. ' ' .$postEntry['title']. '</div>
			<div class="entryMain">
			<div>' .summary($replyEntry['content']). '</div>
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
	$out['content'] .= pageControl($p, $total, 'reply');
}
else
{
	header('Location: index.php?post');
	exit;
}

require 'footer.php';

?>

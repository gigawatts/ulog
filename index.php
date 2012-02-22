<?php

$out['self'] = 'index';
require 'header.php';
require 'include/manage.inc.php';
require 'include/parser.inc.php';
require 'include/page.inc.php';

if(isGET('post'))
{
	$out['subtitle'] = $lang['post'];
	$out['content'] .= '<h1>' .(isAdmin()? '<a href="add.php/post"><i class="icon-plus"></i></a>' : '').$out['subtitle']. '</h1>';
	$posts = listEntry('post');
	rsort($posts);
	$total = totalPage($posts);
	$p = pid($total);
	if($posts)
	{
		foreach(viewPage($posts, $p) as $post)
		{
			$postEntry = readEntry('post', $post);
			$out['content'] .= '<div class="post">
			<div class="title">' .managePost($post).$postEntry['title']. '</div>
			<div class="content">' .summary($postEntry['content']). '</div>
			<p><a class="btn" href="view.php/post/' .$post. '">' .$lang['more']. '</a></p>
			<div class="meta"><ul>';
			if($postEntry['category'] !== '')
			{
				$categoryEntry = readEntry('category', $postEntry['category']);
				$out['content'] .= '<li><a href="view.php/category/' .$postEntry['category']. '">' .$categoryEntry['name']. '</a></li>';
			}
			$out['content'] .= ($postEntry['reply']? '<li>' .$lang['reply']. ' (' .count($postEntry['reply']). ')</li>' : '').
			($postEntry['locked']? '<li>' .$lang['locked']. '</li>' : '').
			'<li>' .$lang['view']. ' (' .shortNum($postEntry['view']). ')</li>
			<li>' .toDate($post). '</li>
			</ul></div>
			</div>';
		}
	}
	else
	{
		$out['content'] .= '<p>' .$lang['none']. '</p>';
	}
	$out['content'] .= pageControl($p, $total, 'index.php/post/o');
}
else if(isGET('reply'))
{
	$out['subtitle'] = $lang['reply'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	$replies = listEntry('reply');
	rsort($replies);
	$total = totalPage($replies);
	$p = pid($total);
	if($replies)
	{
		foreach(viewPage($replies, $p) as $reply)
		{
			$replyEntry = readEntry('reply', $reply);
			$postEntry = readEntry('post', $replyEntry['post']);
			$out['content'] .= '<div class="reply">
			<div class="title">' .manageReply($reply).$replyEntry['trip']. ' ' .$lang['replied']. ' ' .$postEntry['title']. ' - ' .toDate($reply). '</div>
			<div class="content">' .summary($replyEntry['content']). '</div>
			<p><a class="btn" href="view.php/post/' .$replyEntry['post']. '/p/' .onPage($reply, $postEntry['reply']). '#' .$reply. '">' .$lang['more']. '</a></p>
			</div>';
		}
	}
	else
	{
		$out['content'] .= '<p>' .$lang['none']. '</p>';
	}
	$out['content'] .= pageControl($p, $total, 'index.php/reply/o');
}
else if(isGET('404'))
{
	$out['subtitle'] = 'HTTP 404';
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>
	<p>' .$lang['notFound']. '</p>';
}
else
{
	redirect('index.php/post');
}

require 'footer.php';

?>

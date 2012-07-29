<?php

$out['self'] = 'view';
require 'header.php';

if(isGETValidEntry('post', 'post'))
{
	$postEntry = readEntry('post', $_GET['post']);

	$postEntry['view']++;
	saveEntry('post', $_GET['post'], $postEntry);

	$out['subtitle'] = $postEntry['title'].' ['.$postEntry['userid']. ']';
	$out['userid'] = $postEntry['userid'];
	$out['sub_prefix'] = managePost($_GET['post']);
	$out['content'] .= '<div class="post well">
		<div class="content">' . content($postEntry['content']). '</div>'.
		(!$postEntry['locked']? '<div class="btn-toolbar"><a class="btn btn-primary btn-large" href="add.php/reply/' .$_GET['post']. '">' .lang('add reply'). '</a></div>' : '').
		hook('afterPost', $_GET['post']).
		'<div>';
			if($postEntry['category'] !== '')
			{
				$categoryEntry = readEntry('category', $postEntry['category']);
				$out['content'] .= '<a class="label" href="view.php/category/' .$postEntry['category']. '">' .$categoryEntry['name']. '</a>';
			}
			$out['content'] .= ($postEntry['reply']? '<a class="label">' .$lang['reply']. ' (' .count($postEntry['reply']). ')</a>' : '').
			'<a class="label">' .$lang['view']. ' (' .shortNum($postEntry['view']). ')</a>
			<a class="label">' .toDate($_GET['post']). '</a>
		</div>
	</div>';
	$total = countPage($postEntry['reply']);
	$p = pid($total);
	if($postEntry['reply'])
	{
		foreach(viewPage($postEntry['reply'], $p) as $reply)
		{
			$replyEntry = readEntry('reply', $reply);
			$out['content'] .= '<div id="' .$reply. '" class="reply well">
				<div class="title">' .manageReply($reply).$replyEntry['trip']. ' - ' .toDate($reply). '</div>
				<div class="content">' .content($replyEntry['content']). '</div>'.
				(!$postEntry['locked']? '<div class="btn-toolbar"><a class="btn" href="add.php/reply/' .$_GET['post']. '/q/' .$reply. '">' .lang('add reply'). '</a></div>' : '').
				hook('afterReply', $reply).
			'</div>';
		}
	}
	$out['content'] .= pageLink($p, $total, 'view.php/post/' .$_GET['post']);
}
else if(isGETValidEntry('category', 'category'))
{
	$categoryEntry = readEntry('category', $_GET['category']);
	$out['subtitle'] = $categoryEntry['name'];
	$out['sub_prefix'] = manageCategory($_GET['category']);
	$out['content'] .= '<ul>';
	if($categoryEntry['post'])
	{
		foreach($categoryEntry['post'] as $post)
		{
			$postEntry = readEntry('post', $post);
			$out['content'] .= '<li>' .managePost($post). '<a href="view.php/post/' .$post. '">' .$postEntry['title']. '</a> - ' .toDate($post). '</li>';
		}
	}
	else
	{
		$out['content'] .= '<li>' .$lang['none']. '</li>';
	}
	$out['content'] .= '</ul>';
}
else if(isGET('archive') && strlen($_GET['archive']) === 4)
{
	$archivedPosts = array();
	$posts = listEntry('post');
	sort($posts);
	foreach($posts as $post)
	{
		if($_GET['archive'] === substr($post, 0, 4))
		{
			$month = substr($post, 5, 2);
			$archivedPosts[$month][] = $post;
		}
	}
	if(!$archivedPosts)
	{
		exit;
	}
	$out['subtitle'] = $_GET['archive'];
	foreach($archivedPosts as $monthPosts)
	{
		$out['content'] .= '<b>' .toDate($monthPosts[0], 'M'). '</b>
		<ul>';
		foreach($monthPosts as $post)
		{
			$postEntry = readEntry('post', $post);
			$out['content'] .= '<li>' .toDate($post, 'jS'). ' - ' .managePost($post). '<a href="view.php/post/' .$post. '">' .$postEntry['title']. '</a></li>';
		}
		$out['content'] .= '</ul>';
	}
}
else if(isGETValidHook('view', 'plugin'))
{
	$out['subtitle'] = strtolower($_GET['plugin']);
	$out['content'] .= myHook('view', $_GET['plugin']);
}
else
{
	redirect('index.php/404');
}

require 'footer.php';

?>

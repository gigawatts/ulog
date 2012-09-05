<?php
$out['self'] = 'index';
require 'header.php';

if(isGET('post'))
{
	$out['subtitle'] = $lang['post'];
	$out['sub_prefix'] = isAdmin()? '<a href="add.php/post"><i class="icon-plus"></i></a>' : '';
	$posts = listEntry('post');
	rsort($posts);
	$total = countPage($posts);
	$p = pid($total);
	if($posts)
	{
		foreach(viewPage($posts, $p) as $post)
		{
			$postEntry = readEntry('post', $post);
			$out['content'] .= '<div class="post well">
				<div class="title">' .managePost($post).$postEntry['title'].' ['.$postEntry['userid']. ']</div>
				<div class="content">' .summary($postEntry['content']). '</div>
				<div class="btn-toolbar"><a class="btn" href="view.php/post/' .$post. '">' .$lang['more']. '</a></div>
				<div>';
					if($postEntry['category'] !== '')
					{
						$categoryEntry = readEntry('category', $postEntry['category']);
						$out['content'] .= '<a class="label" href="view.php/category/' .$postEntry['category']. '">' .$categoryEntry['name']. '</a>';
					}
					$out['content'] .= ($postEntry['reply']? '<a class="label">' .$lang['reply']. ' (' .count($postEntry['reply']). ')</a>' : '').
					($postEntry['locked']? '<a class="label">' .$lang['locked']. '</a>' : '').
					'<a class="label">' .$lang['view']. ' (' .shortNum($postEntry['view']). ')</a>
					<a class="label">' .toDate($post). '</a>
				</div>
			</div>';
		}
	}
	else
	{
		$out['content'] .= '<p>' .$lang['none']. '</p>';
	}
	$out['content'] .= pageLink($p, $total, 'index.php/post/o');
}
else if(isGET('reply'))
{
	$out['subtitle'] = $lang['reply'];
	$replies = listEntry('reply');
	rsort($replies);
	$total = countPage($replies);
	$p = pid($total);
	if($replies)
	{
		foreach(viewPage($replies, $p) as $reply)
		{
			$replyEntry = readEntry('reply', $reply);
			$postEntry = readEntry('post', $replyEntry['post']);
			$out['content'] .= '<div class="reply well">
				<div class="title">' .manageReply($reply).$replyEntry['trip']. ' ' .$lang['replied']. ' ' .$postEntry['title']. ' - ' .toDate($reply). '</div>
				<div class="content">' .summary($replyEntry['content']). '</div>
				<div class="btn-toolbar"><a class="btn" href="view.php/post/' .$replyEntry['post']. '/p/' .onPage($reply, $postEntry['reply']). '#' .$reply. '">' .$lang['more']. '</a></div>
			</div>';
		}
	}
	else
	{
		$out['content'] .= '<p>' .$lang['none']. '</p>';
	}
	$out['content'] .= pageLink($p, $total, 'index.php/reply/o');
}
else if(isGET('404'))
{
	$out['subtitle'] = 'HTTP 404';
	$out['content'] .= '<p>' .$lang['notFound']. '</p>';
}
else
{
	redirect('index.php/post');
}

require 'footer.php';

?>

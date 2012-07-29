<?php

$out['self'] = 'feed';
require 'header.php';

if(isGET('post'))
{
	$out['subtitle'] = $lang['post'];
	$out['type'] = 'post';
	$posts = _max(listEntry('post'), 6);
	if($posts)
	{
		foreach($posts as $post)
		{
			$postEntry = readEntry('post', $post);
			$url = 'view.php/post/' .$post;
			$out['content'] .= '<entry>
				<id>' .$out['baseURL'].$url. '</id>
				<title>' .$postEntry['title'].' ['.$postEntry['userid']. ']</title>
				<updated>' .toDate($post, 'c'). '</updated>
				<link href="' .$out['baseURL'].$url. '"/>
				<userid>' .$postEntry['userid']. '</userid>
				<summary type="html">' .htmlspecialchars(summary($postEntry['content']), ENT_QUOTES). '</summary>
			</entry>';
		}
	}
}
else if(isGET('reply'))
{
	$out['subtitle'] = $lang['reply'];
	$out['type'] = 'reply';
	$replies = _max(listEntry('reply'), 6);
	if($replies)
	{
		foreach($replies as $reply)
		{
			$replyEntry = readEntry('reply', $reply);
			$postEntry = readEntry('post', $replyEntry['post']);
			$url = 'view.php/post/' .$replyEntry['post']. '/p/' .onPage($reply, $postEntry['reply']). '#' .$reply;
			$out['content'] .= '<entry>
				<id>' .$out['baseURL'].$url. '</id>
				<title>' .$replyEntry['trip']. ' ' .$lang['replied']. ' ' .$postEntry['title']. '</title>
				<updated>' .toDate($reply, 'c'). '</updated>
				<link href="' .$url. '"/>
				<summary type="html">' .htmlspecialchars(summary($replyEntry['content']), ENT_QUOTES). '</summary>
			</entry>';
		}
	}
}
else
{
	exit;
}

require 'footer.php';

?>

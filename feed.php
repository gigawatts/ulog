<?php

$template = 'feed';
require 'header.php';
require 'include/parser.inc.php';

$dir = dirname($_SERVER['SCRIPT_NAME']);
$out['url'] = 'http://' .$_SERVER['SERVER_NAME'].$dir.($dir === '/'? '' : '/');

if(isGET('post'))
{
	$out['subtitle'] = $lang['post'];
	$out['type'] = 'post';
	$posts = top(4, listEntry('post'));
	if($posts)
	{
		foreach($posts as $post)
		{
			$postEntry = readEntry('post', $post);
			$url = $out['url']. 'view.php?post=' .$post;
			$out['content'] .= '<entry>
			<id>' .$url. '</id>
			<title>' .$postEntry['title']. '</title>
			<updated>' .entryDate($post, 'c'). '</updated>
			<link href="' .$url. '"/>
			<summary type="html">' .htmlspecialchars(summary($postEntry['content']), ENT_QUOTES). '</summary>
			</entry>';
		}
	}
}
else if(isGET('reply'))
{
	$out['subtitle'] = $lang['reply'];
	$out['type'] = 'reply';
	$replies = top(4, listEntry('reply'));
	if($replies)
	{
		foreach($replies as $reply)
		{
			$replyEntry = readEntry('reply', $reply);
			$postEntry = readEntry('post', $replyEntry['post']);
			$url = $out['url']. 'view.php?post=' .$replyEntry['post']. '&amp;p=' .onPage($reply, $postEntry['reply']). '#' .$reply;
			$out['content'] .= '<entry>
			<id>' .$url. '</id>
			<title>' .$replyEntry['trip']. ' ' .$lang['replied']. ' ' .$postEntry['title']. '</title>
			<updated>' .entryDate($reply, 'c'). '</updated>
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

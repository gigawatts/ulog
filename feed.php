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
	$posts = listEntry('post');
	rsort($posts);
	$posts = array_slice($posts, 0, 4);
	if($posts)
	{
		foreach($posts as $post)
		{
			$postEntry = readEntry('post', $post);
			$out['content'] .= '<entry>
			<id>' .$out['url']. 'view.php?post=' .$post. '</id>
			<title>' .$postEntry['title']. '</title>
			<updated>' .entryDate($post, 'c'). '</updated>
			<link href="' .$out['url']. 'view.php?post=' .$post. '"/>
			<summary type="html">' .htmlspecialchars(summary($postEntry['content']), ENT_QUOTES). '</summary>
			</entry>';
		}
	}
}
else if(isGET('reply'))
{
	$out['subtitle'] = $lang['reply'];
	$out['type'] = 'reply';
	$replies = listEntry('reply');
	rsort($replies);
	$replies = array_slice($replies, 0, 4);
	if($replies)
	{
		foreach($replies as $reply)
		{
			$replyEntry = readEntry('reply', $reply);
			$postEntry = readEntry('post', $replyEntry['post']);
			$out['content'] .= '<entry>
			<id>' .$out['url']. 'view.php?post=' .$replyEntry['post']. '#' .$reply. '</id>
			<title>' .$replyEntry['trip']. ' - ' .$postEntry['title']. '</title>
			<updated>' .entryDate($reply, 'c'). '</updated>
			<link href="' .$out['url']. 'view.php?post=' .$replyEntry['post']. '#' .$reply. '"/>
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

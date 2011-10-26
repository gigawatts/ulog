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
else if(isGET('comment'))
{
	$out['subtitle'] = $lang['comment'];
	$out['type'] = 'comment';
	$comments = listEntry('comment');
	rsort($comments);
	$comments = array_slice($comments, 0, 4);
	if($comments)
	{
		foreach($comments as $comment)
		{
			$commentEntry = readEntry('comment', $comment);
			$postEntry = readEntry('post', $commentEntry['post']);
			$out['content'] .= '<entry>
			<id>' .$out['url']. 'view.php?post=' .$commentEntry['post']. '#' .$comment. '</id>
			<title>' .$commentEntry['trip']. ' - ' .$postEntry['title']. '</title>
			<updated>' .entryDate($comment, 'c'). '</updated>
			<link href="' .$out['url']. 'view.php?post=' .$commentEntry['post']. '#' .$comment. '"/>
			<summary type="html">' .htmlspecialchars(summary($commentEntry['content']), ENT_QUOTES). '</summary>
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

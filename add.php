<?php

$template = 'main';
require 'header.php';

if(isGET('post') && $_SESSION['admin'])
{
	$out['subtitle'] = $lang['add'].$lang['post'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	if(checkBot() && check('title') && check('content', 1, 2000))
	{
		$postEntry['title'] = clean($_POST['title']);
		$postEntry['content'] = clean($_POST['content']);
		$postEntry['view'] = 0;
		$postEntry['comment'] = array();
		$postEntry['category'] = '';
		$postEntry['locked'] = false;
		$post = newEntry();
		saveEntry('post', $post, $postEntry);
		$out['content'] .= '<p><a href = "view.php?post=' .$post. '">← ' .$lang['redirect']. ' : ' .$postEntry['title']. '</a></p>';
	}
	else
	{
		$out['content'] .= '<form action = "add.php?post" method = "post">
		<p>' .text('title'). '</p>
		<p>' .textarea(). '</p>
		<p>' .submit(). '</p>
		</form>';
	}
}
else if(isGET('comment') && isValidEntry('post', $_GET['comment']))
{
	$postEntry = readEntry('post', $_GET['comment']);
	if($postEntry['locked'])
	{
		exit;
	}
	$out['subtitle'] = $lang['add'].$lang['comment']. ' : ' .$postEntry['title'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	if(checkBot() && check('name') && check('content', 1, 2000))
	{
		$commentEntry['author'] = clean($_POST['name']);
		$commentEntry['content'] = clean($_POST['content']);
		$commentEntry['post'] = $_GET['comment'];
		$comment = newEntry();
		saveEntry('comment', $comment, $commentEntry);

		$postEntry['comment'][$comment] = $comment;
		saveEntry('post', $_GET['comment'], $postEntry);
		$out['content'] .= '<p><a href = "view.php?post=' .$_GET['comment']. '#' .$comment. '">← ' .$lang['redirect']. ' : ' .$postEntry['title']. '</a></p>';
	}
	else
	{
		$out['content'] .= '<form action = "add.php?comment=' .$_GET['comment']. '" method = "post">
		<p>' .text('name'). '</p>
		<p>' .textarea(). '</p>
		<p>' .submit(). '</p>
		</form>';
	}
}
else if(isGET('link') && $_SESSION['admin'])
{
	$out['subtitle'] = $lang['add'].$lang['link'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	if(checkBot() && check('name') && check('url', 1, 80))
	{
		$linkEntry['name'] = clean($_POST['name']);
		$linkEntry['url'] = clean($_POST['url']);
		saveEntry('link', newEntry(), $linkEntry);
		$out['content'] .= '<p><a href = "index.php?more">← ' .$lang['redirect']. ' : ' .$lang['more']. '</a></p>';
	}
	else
	{
		$out['content'] .= '<form action = "add.php?link" method = "post">
		<p>' .text('name'). '</p>
		<p>' .text('url'). '</p>
		<p>' .submit(). '</p>
		</form>';
	}
}
else if(isGET('category') && $_SESSION['admin'])
{
	$out['subtitle'] = $lang['add'].$lang['category'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	if(checkBot() && check('name'))
	{
		$categoryEntry['name'] = clean($_POST['name']);
		$categoryEntry['post'] = array();
		saveEntry('category', newEntry(), $categoryEntry);
		$out['content'] .= '<p><a href = "index.php?more">← ' .$lang['redirect']. ' : ' .$lang['more']. '</a></p>';
	}
	else
	{
		$out['content'] .= '<form action = "add.php?category" method = "post">
		<p>' .text('name'). '</p>
		<p>' .submit(). '</p>
		</form>';
	}
}
else
{
	exit;
}

require 'footer.php';

?>

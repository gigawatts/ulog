<?php

$out['self'] = 'add';
require 'header.php';

if(isGET('post') && isAdmin())
{
	$out['subtitle'] = lang('add post');
	if(checkBot() && check('title') && check('content', 1, 2000))
	{
		$postEntry['title'] = clean($_POST['title']);
		$postEntry['content'] = transNL(clean($_POST['content']));
		$postEntry['view'] = 0;
		$postEntry['reply'] = array();
		$postEntry['category'] = '';
		$postEntry['locked'] = false;
		$post = newEntry();
		saveEntry('post', $post, $postEntry);
		$out['content'] .= '<p><a href="view.php/post/' .$post. '">← ' .$lang['redirect']. ' : ' .$postEntry['title']. '</a></p>';
	}
	else
	{
		$out['content'] .= form('add.php/post',
			text('title').
			textarea('content').
			submit()).
		preview('content');
	}
}
else if(isGETValidEntry('post', 'reply'))
{
	$postEntry = readEntry('post', $_GET['reply']);
	if($postEntry['locked'])
	{
		exit;
	}
	$out['subtitle'] = lang('add reply : %s', $postEntry['title']);
	if(checkBot() && check('trip', 0, 20) && check('content', 1, 2000))
	{
		$replyEntry['content'] = transNL(clean($_POST['content']));
		$replyEntry['post'] = $_GET['reply'];
		$reply = newEntry();
		$replyEntry['trip'] = trip(clean($_POST['trip']), $reply);
		saveEntry('reply', $reply, $replyEntry);

		$postEntry['reply'][$reply] = $reply;
		saveEntry('post', $_GET['reply'], $postEntry);

		$_SESSION[$reply] = $reply;
		$out['content'] .= '<p><a href="view.php/post/' .$_GET['reply']. '/p/' .onPage($reply, $postEntry['reply']). '#' .$reply. '">← ' .$lang['redirect']. ' : ' .$postEntry['title']. '</a></p>';
	}
	else
	{
		$out['content'] .= form('add.php/reply/' .$_GET['reply'],
			text('trip').
			textarea('content', isGETValidEntry('reply', 'q')? '[quote]' .$_GET['q']. '[/quote]' : '').
			submit()).
		preview('content');
	}
}
else if(isGET('link') && isAdmin())
{
	$out['subtitle'] = lang('add link');
	if(checkBot() && check('name') && check('url', 1, 80))
	{
		$linkEntry['name'] = clean($_POST['name']);
		$linkEntry['url'] = clean($_POST['url']);
		saveEntry('link', newEntry(), $linkEntry);
		$out['content'] .= '<p><a href="index.php/post">← ' .$lang['redirect']. ' : ' .$lang['post']. '</a></p>';
	}
	else
	{
		$out['content'] .= form('add.php/link',
			text('name').
			text('url').
			submit());
	}
}
else if(isGET('category') && isAdmin())
{
	$out['subtitle'] = lang('add category');
	if(checkBot() && check('name'))
	{
		$categoryEntry['name'] = clean($_POST['name']);
		$categoryEntry['post'] = array();
		saveEntry('category', newEntry(), $categoryEntry);
		$out['content'] .= '<p><a href="index.php/post">← ' .$lang['redirect']. ' : ' .$lang['post']. '</a></p>';
	}
	else
	{
		$out['content'] .= form('add.php/category',
			text('name').
			submit());
	}
}
else
{
	exit;
}

require 'footer.php';

?>

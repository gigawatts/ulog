<?php

$template = 'main';
require 'header.php';

if(isGET('post') && isAdmin())
{
	$out['subtitle'] = $lang['add'].$lang['post'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	if(checkBot() && check('title') && check('content', 1, 2000))
	{
		$postEntry['title'] = clean($_POST['title']);
		$postEntry['content'] = clean($_POST['content']);
		$postEntry['view'] = 0;
		$postEntry['reply'] = array();
		$postEntry['category'] = '';
		$postEntry['locked'] = false;
		$post = newEntry();
		saveEntry('post', $post, $postEntry);
		$out['content'] .= '<p><a href="view.php?post=' .$post. '">← ' .$lang['redirect']. ' : ' .$postEntry['title']. '</a></p>';
	}
	else
	{
		require 'include/parser.inc.php';
		$out['content'] .= '<form action="add.php?post" method="post">
		<p>' .text('title'). '</p>
		<p>' .textarea('content'). '</p>
		<p>' .submit(). '</p>
		</form>'.
		(isPOST('content')? '<p class="box">' .content(clean($_POST['content'])). '</p>' : '');
	}
}
else if(isGET('reply') && isValidEntry('post', $_GET['reply']))
{
	$postEntry = readEntry('post', $_GET['reply']);
	if($postEntry['locked'])
	{
		exit;
	}
	$out['subtitle'] = $lang['add'].$lang['reply']. ' : ' .$postEntry['title'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	if(checkBot() && check('name', 0, 20) && check('content', 1, 2000))
	{
		$replyEntry['content'] = clean($_POST['content']);
		$replyEntry['post'] = $_GET['reply'];
		$reply = newEntry();
		$replyEntry['trip'] = $_POST['name'] === ''? substr($reply, -5) : trip(clean($_POST['name']));	
		saveEntry('reply', $reply, $replyEntry);

		$postEntry['reply'][$reply] = $reply;
		saveEntry('post', $_GET['reply'], $postEntry);
		
		$_SESSION[$reply] = $reply;
		$out['content'] .= '<p><a href="view.php?post=' .$_GET['reply']. '&amp;p=' .onPage($reply, $postEntry['reply']). '#' .$reply. '">← ' .$lang['redirect']. ' : ' .$postEntry['title']. '</a></p>';
	}
	else
	{	
		require 'include/parser.inc.php';
		$out['content'] .= '<form action="add.php?reply=' .$_GET['reply']. '" method="post">
		<p>' .text('name'). '</p>
		<p>' .textarea('content', isGET('q') && isValidEntry('reply', $_GET['q'])? '[quote]' .$_GET['q']. '[/quote]' : ''). '</p>
		<p>' .submit(). '</p>
		</form>'.
		(isPOST('content')? '<p class="box">' .content(clean($_POST['content'])). '</p>' : '');
	}
}
else if(isGET('link') && isAdmin())
{
	$out['subtitle'] = $lang['add'].$lang['link'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	if(checkBot() && check('name') && check('url', 1, 80))
	{
		$linkEntry['name'] = clean($_POST['name']);
		$linkEntry['url'] = clean($_POST['url']);
		saveEntry('link', newEntry(), $linkEntry);
		$out['content'] .= '<p><a href="index.php?post">← ' .$lang['redirect']. ' : ' .$lang['post']. '</a></p>';
	}
	else
	{
		$out['content'] .= '<form action="add.php?link" method="post">
		<p>' .text('name'). '</p>
		<p>' .text('url'). '</p>
		<p>' .submit(). '</p>
		</form>';
	}
}
else if(isGET('category') && isAdmin())
{
	$out['subtitle'] = $lang['add'].$lang['category'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	if(checkBot() && check('name'))
	{
		$categoryEntry['name'] = clean($_POST['name']);
		$categoryEntry['post'] = array();
		saveEntry('category', newEntry(), $categoryEntry);
		$out['content'] .= '<p><a href="index.php?post">← ' .$lang['redirect']. ' : ' .$lang['post']. '</a></p>';
	}
	else
	{
		$out['content'] .= '<form action="add.php?category" method="post">
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

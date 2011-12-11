<?php

$template = 'main';
require 'header.php';

if(isGET('post') && isAdmin() && isValidEntry('post', $_GET['post']))
{
	$postEntry = readEntry('post', $_GET['post']);
	$out['subtitle'] = $lang['edit'].$lang['post']. ' : ' .$postEntry['title'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	if(checkBot() && check('title') && check('content', 1, 2000) &&
		isPOST('locked') && ($_POST['locked'] === 'yes' || $_POST['locked'] === 'no') &&
		isPOST('category') && ($_POST['category'] === '' || isValidEntry('category', $_POST['category'])))
	{
		$postEntry['title'] = clean($_POST['title']);
		$postEntry['content'] = clean($_POST['content']);

		$postEntry['locked'] = $_POST['locked'] === 'yes';

		if($postEntry['category'] !== $_POST['category'])
		{
			if($postEntry['category'] !== '')
			{
				$categoryEntry = readEntry('category', $postEntry['category']);
				unset($categoryEntry['post'][$_GET['post']]);
				saveEntry('category', $postEntry['category'], $categoryEntry);

				$postEntry['category'] = '';
			}
			if($_POST['category'] !== '')
			{
				$postEntry['category'] = $_POST['category'];

				$categoryEntry = readEntry('category', $postEntry['category']);
				$categoryEntry['post'][$_GET['post']] = $_GET['post'];
				saveEntry('category', $postEntry['category'], $categoryEntry);
			}
		}
		saveEntry('post', $_GET['post'], $postEntry);
		$out['content'] .= '<p><a href="view.php?post=' .$_GET['post']. '">← ' .$lang['redirect']. ' : ' .$postEntry['title']. '</a></p>';
	}
	else
	{
		require 'include/parser.inc.php';
		$categoryOptions[''] = $lang['uncategorized'];
		foreach(listEntry('category') as $category)
		{
			$categoryEntry = readEntry('category', $category);
			$categoryOptions[$category] = $categoryEntry['name'];
		}
		$out['content'] .= '<form action="edit.php?post=' .$_GET['post']. '" method="post">
		<p>' .text('title', $postEntry['title']). '</p>
		<p>' .textarea('content', $postEntry['content']). '</p>
		<p>' .select('locked', array('yes' => $lang['yes'], 'no' => $lang['no']), $postEntry['locked']? 'yes' : 'no'). ' ' .select('category', $categoryOptions, $postEntry['category']). '</p>
		<p>' .submit(). '</p>
		</form>'.
		(isPOST('content')? '<p class="box">' .content(clean($_POST['content'])). '</p>' : '');
	}
}
else if(isGET('reply') && (isAdmin() || isAuthor($_GET['reply'])) && isValidEntry('reply', $_GET['reply']))
{
	$replyEntry = readEntry('reply', $_GET['reply']);
	$out['subtitle'] = $lang['edit'].$lang['reply'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	if(checkBot() && check('content', 1, 2000))
	{
		$replyEntry['content'] = clean($_POST['content']);
		saveEntry('reply', $_GET['reply'], $replyEntry);
		$postEntry = readEntry('post', $replyEntry['post']);
		$out['content'] .= '<p><a href="view.php?post=' .$replyEntry['post']. '&amp;p=' .onPage($_GET['reply'], $postEntry['reply']). '#' .$_GET['reply']. '">← ' .$lang['redirect']. ' : ' .$postEntry['title']. '</a></p>';
	}
	else
	{
		require 'include/parser.inc.php';
		$out['content'] .= '<form action="edit.php?reply=' .$_GET['reply']. '" method="post">
		<p>' .textarea('content', $replyEntry['content']). '</p>
		<p>' .submit(). '</p>
		</form>'.
		(isPOST('content')? '<p class="box">' .content(clean($_POST['content'])). '</p>' : '');
	}
}
else if(isGET('link') && isAdmin() && isValidEntry('link', $_GET['link']))
{
	$linkEntry = readEntry('link', $_GET['link']);
	$out['subtitle'] = $lang['edit'].$lang['link']. ' : ' .$linkEntry['name'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	if(checkBot() && check('name') && check('url', 1, 80))
	{
		$linkEntry['name'] = clean($_POST['name']);
		$linkEntry['url'] = clean($_POST['url']);
		saveEntry('link', $_GET['link'], $linkEntry);
		$out['content'] .= '<p><a href="index.php?post">← ' .$lang['redirect']. ' : ' .$lang['post']. '</a></p>';
	}
	else
	{
		$out['content'] .= '<form action="edit.php?link=' .$_GET['link']. '" method="post">
		<p>' .text('name', $linkEntry['name']). '</p>
		<p>' .text('url', $linkEntry['url']). '</p>
		<p>' .submit(). '</p>
		</form>';
	}
}
else if(isGET('category') && isAdmin() && isValidEntry('category', $_GET['category']))
{
	$categoryEntry = readEntry('category', $_GET['category']);
	$out['subtitle'] = $lang['edit'].$lang['category']. ' : ' .$categoryEntry['name'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	if(checkBot() && check('name'))
	{
		$categoryEntry['name'] = clean($_POST['name']);
		saveEntry('category', $_GET['category'], $categoryEntry);
		$out['content'] .= '<p><a href="index.php?post">← ' .$lang['redirect']. ' : ' .$lang['post']. '</a></p>';
	}
	else
	{
		$out['content'] .= '<form action="edit.php?category=' .$_GET['category']. '" method="post">
		<p>' .text('name', $categoryEntry['name']). '</p>
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

<?php

$template = 'main';
require 'header.php';

if(isGET('post') && $_SESSION['admin'] && isValidEntry('post', $_GET['post']))
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
		$out['content'] .= '<p><a href = "view.php?post=' .$_GET['post']. '">← ' .$lang['redirect']. ' : ' .$postEntry['title']. '</a></p>';
	}
	else
	{
		$commentOptions['yes'] = $lang['yes'];
		$commentOptions['no'] = $lang['no'];

		$categoryOptions[''] = $lang['uncategorized'];
		$categories = listEntry('category');
		foreach($categories as $category)
		{
			$categoryEntry = readEntry('category', $category);
			$categoryOptions[$category] = $categoryEntry['name'];
		}
		$out['content'] .= '<form action = "edit.php?post=' .$_GET['post']. '" method = "post">
		<p>' .text('title', $postEntry['title']). '</p>
		<p>' .textarea($postEntry['content']). '</p>
		<p>' .select('locked', $commentOptions, $postEntry['locked']? 'yes' : 'no'). ' ' .select('category', $categoryOptions, $postEntry['category']). '</p>
		<p>' .submit(). '</p>
		</form>';
	}
}
else if(isGET('comment') && $_SESSION['admin'] && isValidEntry('comment', $_GET['comment']))
{
	$commentEntry = readEntry('comment', $_GET['comment']);
	$out['subtitle'] = $lang['edit'].$lang['comment'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	if(checkBot() && check('content', 1, 2000))
	{
		$commentEntry['content'] = clean($_POST['content']);
		saveEntry('comment', $_GET['comment'], $commentEntry);
		$postEntry = readEntry('post', $commentEntry['post']);
		$out['content'] .= '<p><a href = "view.php?post=' .$commentEntry['post']. '">← ' .$lang['redirect']. ' : ' .$postEntry['title']. '</a></p>';
	}
	else
	{
		$out['content'] .= '<form action = "edit.php?comment=' .$_GET['comment']. '" method = "post">
		<p>' .textarea($commentEntry['content']). '</p>
		<p>' .submit(). '</p>
		</form>';
	}
}
else if(isGET('link') && $_SESSION['admin'] && isValidEntry('link', $_GET['link']))
{
	$linkEntry = readEntry('link', $_GET['link']);
	$out['subtitle'] = $lang['edit'].$lang['link']. ' : ' .$linkEntry['name'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	if(checkBot() && check('name') && check('url', 1, 80))
	{
		$linkEntry['name'] = clean($_POST['name']);
		$linkEntry['url'] = clean($_POST['url']);
		saveEntry('link', $_GET['link'], $linkEntry);
		$out['content'] .= '<p><a href = "index.php?more">← ' .$lang['redirect']. ' : ' .$lang['more']. '</a></p>';
	}
	else
	{
		$out['content'] .= '<form action = "edit.php?link=' .$_GET['link']. '" method = "post">
		<p>' .text('name', $linkEntry['name']). '</p>
		<p>' .text('url', $linkEntry['url']). '</p>
		<p>' .submit(). '</p>
		</form>';
	}
}
else if(isGET('category') && $_SESSION['admin'] && isValidEntry('category', $_GET['category']))
{
	$categoryEntry = readEntry('category', $_GET['category']);
	$out['subtitle'] = $lang['edit'].$lang['category']. ' : ' .$categoryEntry['name'];
	$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';
	if(checkBot() && check('name'))
	{
		$categoryEntry['name'] = clean($_POST['name']);
		saveEntry('category', $_GET['category'], $categoryEntry);
		$out['content'] .= '<p><a href = "index.php?more">← ' .$lang['redirect']. ' : ' .$lang['more']. '</a></p>';
	}
	else
	{
		$out['content'] .= '<form action = "edit.php?category=' .$_GET['category']. '" method = "post">
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

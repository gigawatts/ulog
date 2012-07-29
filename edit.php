<?php

$out['self'] = 'edit';
require 'header.php';

if(isGETValidEntry('post', 'post') && isAdmin())
{
	$postEntry = readEntry('post', $_GET['post']);
	$out['subtitle'] = lang('edit post : %s', $postEntry['title']);
	if(checkBot() && check('title') && check('content', 1, 2000) &&
		isPOST('locked') && ($_POST['locked'] === 'yes' || $_POST['locked'] === 'no') &&
		isPOST('category') && ($_POST['category'] === '' || isValidEntry('category', $_POST['category'])))
	{
		$postEntry['title'] = clean($_POST['title']);
		$postEntry['content'] = transNL(clean($_POST['content']));

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
		$out['content'] .= '<p><a href="view.php/post/' .$_GET['post']. '">← ' .$lang['redirect']. ' : ' .$postEntry['title']. '</a></p>';
	}
	else
	{
		$categoryOptions[''] = $lang['uncategorized'];
		foreach(listEntry('category') as $category)
		{
			$categoryEntry = readEntry('category', $category);
			$categoryOptions[$category] = $categoryEntry['name'];
		}
		$out['content'] .= form('edit.php/post/' .$_GET['post'],
			text('title', $postEntry['title']).
			textarea('content', $postEntry['content']).
			select('locked', array('yes' => $lang['yes'], 'no' => $lang['no']), $postEntry['locked']? 'yes' : 'no').
			select('category', $categoryOptions, $postEntry['category']).
			submit()).
		preview('content');
	}
}
else if(isGETValidEntry('reply', 'reply') && (isAdmin() || isAuthor($_GET['reply'])))
{
	$replyEntry = readEntry('reply', $_GET['reply']);
	$out['subtitle'] = lang('edit reply');
	if(checkBot() && check('content', 1, 2000))
	{
		$replyEntry['content'] = transNL(clean($_POST['content']));
		saveEntry('reply', $_GET['reply'], $replyEntry);
		$postEntry = readEntry('post', $replyEntry['post']);
		$out['content'] .= '<p><a href="view.php/post/' .$replyEntry['post']. '/p/' .onPage($_GET['reply'], $postEntry['reply']). '#' .$_GET['reply']. '">← ' .$lang['redirect']. ' : ' .$postEntry['title']. '</a></p>';
	}
	else
	{
		$out['content'] .= form('edit.php/reply/' .$_GET['reply'],
			textarea('content', $replyEntry['content']).
			submit()).
		preview('content');
	}
}
else if(isGETValidEntry('link', 'link') && isAdmin())
{
	$linkEntry = readEntry('link', $_GET['link']);
	$out['subtitle'] = lang('edit link : %s', $linkEntry['name']);
	if(checkBot() && check('name') && check('url', 1, 80))
	{
		$linkEntry['name'] = clean($_POST['name']);
		$linkEntry['url'] = clean($_POST['url']);
		saveEntry('link', $_GET['link'], $linkEntry);
		$out['content'] .= '<p><a href="index.php/post">← ' .$lang['redirect']. ' : ' .$lang['post']. '</a></p>';
	}
	else
	{
		$out['content'] .= form('edit.php/link/' .$_GET['link'],
			text('name', $linkEntry['name']).
			text('url', $linkEntry['url']).
			submit());
	}
}
else if(isGETValidEntry('category', 'category') && isAdmin())
{
	$categoryEntry = readEntry('category', $_GET['category']);
	$out['subtitle'] = lang('edit category : %s', $categoryEntry['name']);
	if(checkBot() && check('name'))
	{
		$categoryEntry['name'] = clean($_POST['name']);
		saveEntry('category', $_GET['category'], $categoryEntry);
		$out['content'] .= '<p><a href="index.php/post">← ' .$lang['redirect']. ' : ' .$lang['post']. '</a></p>';
	}
	else
	{
		$out['content'] .= form('edit.php/category/' .$_GET['category'],
			text('name', $categoryEntry['name']).
			submit());
	}
}
else
{
	exit;
}

require 'footer.php';

?>

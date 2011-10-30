<?php

if(!isset($template))
{
	exit;
}

$script = basename($_SERVER['SCRIPT_NAME'], '.php');
if($script === 'index' || $script === 'view' || $script === 'search')
{
	//link
	$out['sidebar'] .= '<h1>' .(isAdmin()? '<a href="add.php?link">[+]</a>' : '').$lang['link']. '</h1>
	<ul>';
	$links = listEntry('link');
	if($links)
	{
		foreach($links as $link)
		{
			$linkEntry = readEntry('link', $link);
			$out['sidebar'] .= '<li>' .manageLink($link). '<a href="' .$linkEntry['url']. '">' .$linkEntry['name']. '</a></li>';
		}
	}
	else
	{
		$out['sidebar'] .= '<li>' .$lang['none']. '</li>';
	}
	$out['sidebar'] .= '</ul>';

	//category
	$out['sidebar'] .= '<h1>' .(isAdmin()? '<a href="add.php?category">[+]</a>' : '').$lang['category']. '</h1>
	<ul>';
	$categories = listEntry('category');
	if($categories)
	{
		foreach($categories as $category)
		{
			$categoryEntry = readEntry('category', $category);
			$out['sidebar'] .= '<li>' .manageCategory($category). '<a href="view.php?category=' .$category. '">' .$categoryEntry['name']. ' (' .count($categoryEntry['post']). ')</a></li>';
		}
	}
	else
	{
		$out['sidebar'] .= '<li>' .$lang['none']. '</li>';
	}
	$out['sidebar'] .= '</ul>';

	//archive
	$posts = listEntry('post');
	$archives = array();
	foreach($posts as $post)
	{
		$archive = substr($post, 0, 7);
		if(isset($archives[$archive]))
		{
			$archives[$archive]++;
		}
		else
		{
			$archives[$archive] = 1;
		}
	}

	$out['sidebar'] .= '<h1>' .$lang['archive']. '</h1>
	<ul>';
	if($archives)
	{
		foreach($archives as $archive => $count)
		{
			$out['sidebar'] .= '<li><a href="view.php?archive=' .$archive. '">' .date('F Y', strtotime($archive)). ' (' .$count. ')</a></li>';
		}
	}
	else
	{
		$out['sidebar'] .= '<li>' .$lang['none']. '</li>';
	}
	$out['sidebar'] .= '</ul>';
}

require 'template/' .$template. '.tpl.php';

?>

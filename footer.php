<?php

if(!isset($out))
{
	exit;
}

if($out['self'] === 'index' || $out['self'] === 'view' || $out['self'] === 'search')
{
	//link
	$out['sidebar'] .= '<h1>' .(isAdmin()? '<a href="add.php/link"><i class="icon-plus"></i></a>' : '').$lang['link']. '</h1>
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
	$out['sidebar'] .= '<h1>' .(isAdmin()? '<a href="add.php/category"><i class="icon-plus"></i></a>' : '').$lang['category']. '</h1>
	<ul>';
	$categories = listEntry('category');
	if($categories)
	{
		foreach($categories as $category)
		{
			$categoryEntry = readEntry('category', $category);
			$out['sidebar'] .= '<li>' .manageCategory($category). '<a href="view.php/category/' .$category. '">' .$categoryEntry['name']. ' (' .count($categoryEntry['post']). ')</a></li>';
		}
	}
	else
	{
		$out['sidebar'] .= '<li>' .$lang['none']. '</li>';
	}
	$out['sidebar'] .= '</ul>';

	//archive
	$archives = array();
	foreach(listEntry('post') as $post)
	{
		$year = substr($post, 0, 4);
		if(isset($archives[$year]))
		{
			$archives[$year]++;
		}
		else
		{
			$archives[$year] = 1;
		}
	}

	$out['sidebar'] .= '<h1>' .$lang['archive']. '</h1>
	<ul>';
	if($archives)
	{
		foreach($archives as $year => $count)
		{
			$out['sidebar'] .= '<li><a href="view.php/archive/' .$year. '">' .$year. ' (' .$count. ')</a></li>';
		}
	}
	else
	{
		$out['sidebar'] .= '<li>' .$lang['none']. '</li>';
	}
	$out['sidebar'] .= '</ul>';
}

if($out['self'] === 'feed')
{
	require 'theme/' .$config['theme']. '/feed.tpl.php';
}
else
{
	require 'theme/' .$config['theme']. '/main.tpl.php';
}

?>

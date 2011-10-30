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
		$year = substr($post, 0, 4);
		$month = substr($post, 5, 2);
		if(isset($archives[$year][$month]))
		{
			$archives[$year][$month]++;
		}
		else
		{
			$archives[$year][$month] = 1;
		}
	}

	$out['sidebar'] .= '<h1>' .$lang['archive']. '</h1>
	<ul>';
	if($archives)
	{
		foreach($archives as $year => $months)
		{
			$out['sidebar'] .= '<li><b>' .$year. '</b>';
			foreach($months as $month => $count)
			{
				$yearMonth = $year. '-' .$month;
				$out['sidebar'] .= ' <a href="view.php?archive=' .$yearMonth. '">' .date('M', strtotime($yearMonth)). ' (' .$count. ')</a>';
			}
			$out['sidebar'] .= '</li>';
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
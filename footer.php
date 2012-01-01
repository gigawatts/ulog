<?php

if(!isset($out))
{
	exit;
}

if($out['self'] === 'index' || $out['self'] === 'view' || $out['self'] === 'search')
{
	//link
	$out['sidebar'] .= '<h1>' .(isAdmin()? '<a href="add.php/link">[+]</a>' : '').$lang['link']. '</h1>
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
	$out['sidebar'] .= '<h1>' .(isAdmin()? '<a href="add.php/category">[+]</a>' : '').$lang['category']. '</h1>
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
				$out['sidebar'] .= ' <a href="view.php/archive/' .$yearMonth. '">' .date('M', strtotime($yearMonth)). ' (' .$count. ')</a>';
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

if($out['self'] === 'feed')
{
	require 'theme/' .$config['theme']. '/feed.tpl.php';
}
else
{
	require 'theme/' .$config['theme']. '/main.tpl.php';
}

?>

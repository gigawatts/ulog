<?php

$template = 'main';
require 'header.php';
require 'include/manage.inc.php';

$out['subtitle'] = $lang['search'];
$out['content'] .= '<h1>' .$out['subtitle']. '</h1>';

if(checkBot() && check('post'))
{
	$_POST['post'] = clean($_POST['post']);
	$posts = listEntry('post');
	foreach($posts as $post)
	{
		$postEntry = readEntry('post', $post);
		if(strpos($postEntry['title'], $_POST['post']) !== false || strpos($postEntry['content'], $_POST['post']) !== false)
		{
			$foundPosts[$post]['title'] = $postEntry['title'];
		}
	}
	$out['content'] .= '<ul>';
	if($foundPosts)
	{		
		foreach($foundPosts as $post => $postEntry)
		{
			$out['content'] .= '<li>' .managePost($post). '<a href="view.php?post=' .$post. '">' .$postEntry['title']. '</a></li>';
		}
	}
	else
	{
		$out['content'] .= '<li>' .$lang['none']. '</li>';
	}
	$out['content'] .= '</ul>';
}

$out['content'] .= '<form action="search.php" method="post">
<p>' .text('post'). '</p>
<p>' .submit(). '</p>
</form>';

require 'footer.php';

?>

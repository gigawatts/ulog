<?php
$out['self'] = 'index';
require 'header.php';

if(isGET('post'))
{
	$out['subtitle'] = $lang['post'];
	$out['sub_prefix'] = isAdmin()? '<a href="add.php/post"><i class="icon-plus"></i></a>' : '';
	$posts = listEntry('post');
	rsort($posts);
	$total = countPage($posts);
	$p = pid($total);
	if($posts)
	{
		foreach(viewPage($posts, $p) as $post)
		{
			$postEntry = readEntry('post', $post);
			$out['content'] .= '<div class="post well">
				<div class="title">' .managePost($post).$postEntry['title'].' ['.$postEntry['userid']. ']</div>
				<div class="content">' .summary($postEntry['content']). '</div>
				<div class="btn-toolbar"><a class="btn" href="view.php/post/' .$post. '">' .$lang['more']. '</a></div>
				<div>';
					if($postEntry['category'] !== '')
					{
						$categoryEntry = readEntry('category', $postEntry['category']);
						$out['content'] .= '<a class="label" href="view.php/category/' .$postEntry['category']. '">' .$categoryEntry['name']. '</a>';
					}
					$out['content'] .= ($postEntry['reply']? '<a class="label">' .$lang['reply']. ' (' .count($postEntry['reply']). ')</a>' : '').
					($postEntry['locked']? '<a class="label">' .$lang['locked']. '</a>' : '').
					'<a class="label">' .$lang['view']. ' (' .shortNum($postEntry['view']). ')</a>
					<a class="label">' .toDate($post). '</a>
				</div>
			</div>';
		}
	}
	else
	{
		$out['content'] .= '<p>' .$lang['none']. '</p>';
	}
	$out['content'] .= pageLink($p, $total, 'index.php/post/o');
}
else if(isGET('reply'))
{
	$out['subtitle'] = $lang['reply'];
	$replies = listEntry('reply');
	rsort($replies);
	$total = countPage($replies);
	$p = pid($total);
	if($replies)
	{
		foreach(viewPage($replies, $p) as $reply)
		{
			$replyEntry = readEntry('reply', $reply);
			$postEntry = readEntry('post', $replyEntry['post']);
			$out['content'] .= '<div class="reply well">
				<div class="title">' .manageReply($reply).$replyEntry['trip']. ' ' .$lang['replied']. ' ' .$postEntry['title']. ' - ' .toDate($reply). '</div>
				<div class="content">' .summary($replyEntry['content']). '</div>
				<div class="btn-toolbar"><a class="btn" href="view.php/post/' .$replyEntry['post']. '/p/' .onPage($reply, $postEntry['reply']). '#' .$reply. '">' .$lang['more']. '</a></div>
			</div>';
		}
	}
	else
	{
		$out['content'] .= '<p>' .$lang['none']. '</p>';
	}
	$out['content'] .= pageLink($p, $total, 'index.php/reply/o');
}
else if(isGET('404'))
{
	$out['subtitle'] = 'HTTP 404';
	$out['content'] .= '<p>' .$lang['notFound']. '</p>';
}
else if(isGET('help'))
{
        $out['subtitle'] = 'Help';
        $out['content'] .= '<p>' .'So you are looking for some help with something on this site, eh? What do you need help with?'. '</p>
<ul>
<li><a href="index.php/help#Post">Post</a></li>
<li><a href="index.php/help#Reply">Reply</a></li>
<li><a href="index.php/help#Search">Search</a></li>
<li><a href="index.php/help#Category">Category</a></li>
<li><a href="index.php/help#Tag">Tag</a></li>
<li><a href="index.php/help#RSS">RSS Feed</a></li>
</ul>

<br>
<h4 id="Post">Post</h4>
<pre>
making new posts
editing
image attachments
</pre>

<h4 id="Reply">Reply</h4>
<pre>
reply vs new post vs edit
</pre>

<h4 id="Search">Search</h4>
<pre>
tags, predefined searches
url search
</pre>

<h4 id="Category">Category</h4>
<pre>
what category to use for what
</pre>

<h4 id="Tag">Tag</h4>
<pre>
adding tags to quick search
</pre>

<h4 id="RSS">RSS Feed</h4>
<pre>
number of items
programs to use
blackberry
</pre>
';
}
else
{
	redirect('index.php/post');
}

require 'footer.php';

?>

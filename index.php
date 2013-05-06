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
        $out['content'] .= '<p>' .'So you are looking for some help with ULog, eh? Pick a topic to jump to that section'. '</p>
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
<h4>Making new posts</h4>
  To make a new post, navigate to the <a href="index.php/post">"Post"</a> page via the link at the top, and click
the <a href="add.php/post">+ icon</a> towards the top of the page. This brings you to new post page, where, at a
minimum, you must fill in a title and message content. You may also choose a Category
for your post. For more information, see the <a href="index.php/help#Category">Category</a> help section.

  If you are having trouble find the <a href="add.php/post">+ icon</a>, look for the word [Admin] after your
User ID.  If that word does not appear, it means you must request access to publish
to ULog. Please send an email to <a href="mailto:admin@example.com?subject=Request access to publish on ULog">admin@example.com</a> and ask for access.


<h4>Editing</h4>
  To edit a previous post, reply, category, or Tag, simply click the <img src="/ulog/theme/classic/img/edit.png"> icon next to
the post, and make changes to Title, Content, and Category.  The "Locked" option
enables or disables replies to a post.


<h4>Image Attachments</h4>
  You also have the ability to upload images and attach them to posts.  When making a
new post or editing a previous one, first place your text cursor at the point in your
message body where you would like the image to show up, then click the "Choose File"
button next to "Content:". This will bring up a dialog box where you can select an
image from your local computer, and then click Open. Once the file has successfuly
been uploaded, it will show a preview of the image with a line of instructions that
says "[Click image preview to insert a link]". Do as it says, and click the image
once. This should insert a [url] and a nested [img] link into the body of your
message. Simply click ok, and your post should now show up with your uploaded image.

  <b>Please note:</b> There are some file size and type limitations to this upload tool. If
either check fails, your image will not be uploaded, and it should report back with a
descriptive error message. There are some known issues with image upload in Internet
Explorer. The file seems to upload just fine, but clicking the image preview will not
insert a link to the image in the body of the text. A work around for now is to right
click the image preview, click Properties, copy the Address text, paste the address
in the text box, and then enclose it in [img] address [/img] and/or
[url=address] text [/url] tags.


<h4>BB Code</h4>
  The bbcode options are the row of buttons you see above the message body text box,
and below the "Choose file" button. These can be used for formating message text.
Each button can be used by highlighting the text you want to format, and clicking
the appropriate button. You can also click the button first, and then type your text
between the tags that show up.

  The [b] [/b] tags will <b>bold</b> any text contained within
  The [i] [/i] tags will <i>italicize</i> any text contained within
  The [u] [/u] tags will <u>underline</u> any text contained within
  The [s] [/s] tags will <s>strike through</s> any text contained within
  The [ul] [/ul] tags will make an un-ordered list of any items contained within
  The [ol] [/ol] tags will make an ordered list of any items contained within
  The [li] [/li] tags will make a list item out of any text contained within
  The [img]url[/img] tags will make an embedded image out of an URL contained within 
  The [url=link]text[/url] tags will make a hyperlink out of an URL contained within
  The [block] [/block] tags will make a unformated text box out of any text within
      <i>Best used for code or log file snippets</i>

  <b>Note:</b> when using [ul] or [ol] with [li], they must be all entered in one line,
without carrige returns, or formatting will get messed up.

  Good Example: [ol][li]Item One[/li][li]Item Two[/li][li]Item Three[/li][/ol]

  Bad Example:
  [ul]
  [li]Item A[/li]
  [li]Item B[/li]
  [li]Item C[/li]
  [/ul]

  <b>Please note:</b> As with image attachments, the bbcode buttons also have some trouble
with Internet Explorer, however, the bbcode tags still work if manually typed in.
</pre>

<h4 id="Reply">Reply</h4>
<pre>
<h4>Adding a reply</h4>
  If you have input on a previous post, you can reply to it by clickng the "More"
button on any post, then the "Add Reply" button. Then simply add text to the body
of your message, format it using any of the bbcode options, and then click "ok".
Your reply will appear under the main post when anyone clicks the "More" button.


<h4>Showing only replies</h4>
  By clicking the <a href="index.php/reply">"Reply"</a> link at the top of any page, you can view all replies
to all posts in one place.
</pre>

<h4 id="Search">Search</h4>
<pre>
  There are three ways to search ULog. The first is accomplished by clicking the
<a href="search.php">"Search"</a> link at the top of any page, typing your key
word(s) in the "Post" field and clicking "ok". Searches will come back listed
seperatly under Posts and Replies. The query will be executed on titles, message
body text, reply text, and user id.

  The second way to search ULog is by predefined searches called "tags". Tags
are used similar to the way hashtags are on twitter.  You can include a pound
sign, followed by a keyword, to make it easily searchable.   Ex. #hashtag

  The third way to search ULog involves a php post variable that allows you
to start a search directly from the address bar.  Simply navigate to
<a href="search.php?s=keyword">search.php?s=keyword</a> (replacing keyword with your desired query).
</pre>

<h4 id="Category">Category</h4>
<pre>
<h4>Using categories</h4>
  Categories are used to place posts into broad, predefined topics. Here, we
primarily use them to categorize a post as:

  - [Use case #1]
  - [Use case #2]
  - [Use case #3]

  There are also a couple extra categories for [...
Links to each category can be found on the right sidebar on any page of ULog.


<h4>Adding new categories</h4>
Additional categories can be added by clicking the <a href="add.php/category">+ icon</a> next to "Category" on the
main page, adding a name, and clicking "ok". After a new category is added, any post
can be added to it by selecting it from the drop down box in a new post, or by
editing a previous post.
</pre>

<h4 id="Tag">Tag</h4>
<pre>
<h4>Using Tags</h4>
  Tags may also be refered to as "Links" in some parts of ULog. Most of the
information about using tags can be found in the <a href="index.php/help#Search">Search</a> section. Links to all
currently defined tags can be found along the right side bar of every page on ULog.


<h4>Adding new Tags</h4>
  Adding new tags can be accomplished by clicking the <a href="add.php/link">+ icon</a> next to the "Tag"
section on the main page. Enter a Tag name, as well as a search url, such as:
  
  search.php?s=keyword
  OR
  search.php?s=%23hashtag

  The %23 is the ASCII code for # (just entering #hashtag would not work, due to
the way HTML post variables are passed)
</pre>

<h4 id="RSS">RSS Feed</h4>
<pre>
  ULog currently has two RSS feeds (linked at the bottom of every page). One for
<a href="feed.php/post">Posts</a>, and one for <a href="feed.php/reply">Replies</a>.  Each feed contains the last 6 posts or replies
made to ULog. This variable can be tweaked upon request.

  Any RSS feed reader can be used, including the readers built into Firefox and
Internet Explorer.  For chrome, I have found the extention named "Feeder" works
well.

  The blackberry also has a decent built-in RSS reader as part of the mobile
browser. Any reader will need to authenticate to the secure site, which is no
different than when acceessing ULog from a standard browser. 
</pre>
';
}
else
{
	redirect('index.php/post');
}

require 'footer.php';

?>

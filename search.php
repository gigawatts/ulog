<?php

$out['self'] = 'search';
require 'header.php';

$out['subtitle'] = $lang['search'];

if(checkBot() && check('post'))
{
        // find all posts
        $_POST['post'] = clean($_POST['post']);
        $foundPosts = array();
        foreach(listEntry('post') as $post)
        {
                $postEntry = readEntry('post', $post);
                if(stripos($postEntry['title'], $_POST['post']) !== false || stripos($postEntry['content'], $_POST['post']) !== false || stripos($postEntry['userid'], $_POST['post']) !== false)
                {
                        $foundPosts[$post] = $postEntry['title'];
                }
        }

        // find all replies
        $_POST['post'] = clean($_POST['post']);
        $foundReplies = array();
        foreach(listEntry('reply') as $reply)
        {
                $replyEntry = readEntry('reply', $reply);
                if(stripos($replyEntry['content'], $_POST['post']) !== false || stripos($replyEntry['trip'], $_POST['post']) !== false)
                {
                        $foundReplies[$reply] = substr($replyEntry['content'],0,30);
                }
        }

        // generate lists
        $out['content'] .= '<ul><h4>Posts</h4>';
        if($foundPosts)
        {
                foreach($foundPosts as $post => $title)
                {
                        $out['content'] .= '<li>' .managePost($post). '<a href="view.php/post/' .$post. '">' .$title. '</a></li>';
                }
        }
        else
        {
                $out['content'] .= '<li>' .$lang['none']. '</li>';
        }

        $out['content'] .= '<br><h4>Replies</h4>';
        if($foundReplies)
        {
                foreach($foundReplies as $reply => $content)
                {
                        $replyEntry = readEntry('reply', $reply);
                        $postEntry = readEntry('post', $replyEntry['post']);
                        $out['content'] .= '<li>' .managePost($reply). '<a href="view.php/post/' .$replyEntry['post']. '/p/' .onPage($reply, $postEntry['reply']). '#' .$reply. '">' .$content. '</a></li>';
                }
        }
        else
        {
                $out['content'] .= '<li>' .$lang['none']. '</li>';
        }
        $out['content'] .= '</ul>';
}

$out['content'] .= form('search.php',
        text('post').
        submit());

require 'footer.php';

?>

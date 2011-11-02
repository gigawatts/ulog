<?php

function managePost($post)
{
	return (isAdmin()? '<a href="edit.php?post=' .$post. '">[!]</a><a href="delete.php?post=' .$post. '">[x]</a>' : '').hook('managePost', $post);
}

function manageReply($reply)
{
	return (isAdmin() || isAuthor($reply)? '<a href="edit.php?reply=' .$reply. '">[!]</a><a href="delete.php?reply=' .$reply. '">[x]</a>' : '').hook('manageReply', $reply);
}

function manageCategory($category)
{
	return (isAdmin()? '<a href="edit.php?category=' .$category. '">[!]</a><a href="delete.php?category=' .$category. '">[x]</a>' : '').hook('manageCategory', $category);
}

function manageLink($link)
{
	return (isAdmin()? '<a href="edit.php?link=' .$link. '">[!]</a><a href="delete.php?link=' .$link. '">[x]</a>' : '').hook('manageLink', $link);
}

?>

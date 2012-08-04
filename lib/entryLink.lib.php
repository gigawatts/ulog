<?php

function managePost($post)
{
	return (isAdmin()? '<a href="edit.php/post/' .$post. '"><i class="icon-edit"></i></a><a href="delete.php/post/' .$post. '"><i class="icon-remove"></i></a>' : '').hook('managePost', $post);
}

function manageReply($reply)
{
	return (isAdmin()? '<a href="edit.php/reply/' .$reply. '"><i class="icon-edit"></i></a><a href="delete.php/reply/' .$reply. '"><i class="icon-remove"></i></a>' : '').hook('manageReply', $reply);
}

function manageCategory($category)
{
	return (isAdmin()? '<a href="edit.php/category/' .$category. '"><i class="icon-edit"></i></a><a href="delete.php/category/' .$category. '"><i class="icon-remove"></i></a>' : '').hook('manageCategory', $category);
}

function manageLink($link)
{
	return (isAdmin()? '<a href="edit.php/link/' .$link. '"><i class="icon-edit"></i></a><a href="delete.php/link/' .$link. '"><i class="icon-remove"></i></a>' : '').hook('manageLink', $link);
}

?>

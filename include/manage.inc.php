<?php

function managePost($post)
{
	return ($_SESSION['admin']? '<a href = "edit.php?post=' .$post. '">[!]</a><a href = "delete.php?post=' .$post. '">[x]</a>' : '').hook('managePost', $post);
}

function manageComment($comment)
{
	return ($_SESSION['admin']? '<a href = "edit.php?comment=' .$comment. '">[!]</a><a href = "delete.php?comment=' .$comment. '">[x]</a>' : '').hook('manageComment', $comment);
}

function manageCategory($category)
{
	return ($_SESSION['admin']? '<a href = "edit.php?category=' .$category. '">[!]</a><a href = "delete.php?category=' .$category. '">[x]</a>' : '').hook('manageCategory', $category);
}

function manageLink($link)
{
	return ($_SESSION['admin']? '<a href = "edit.php?link=' .$link. '">[!]</a><a href = "delete.php?link=' .$link. '">[x]</a>' : '').hook('manageLink', $link);
}

?>

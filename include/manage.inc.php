<?php

function managePost($post)
{
	global $lang;
	return ($_SESSION['admin']? '<a href = "edit.php?post=' .$post. '">[' .$lang['edit']. ']</a><a href = "delete.php?post=' .$post. '">[' .$lang['delete']. ']</a>' : '').hook('managePost', $post);
}

function manageComment($comment)
{
	global $lang;
	return ($_SESSION['admin']? '<a href = "edit.php?comment=' .$comment. '">[' .$lang['edit']. ']</a><a href = "delete.php?comment=' .$comment. '">[' .$lang['delete']. ']</a>' : '').hook('manageComment', $comment);
}

function manageCategory($category)
{
	global $lang;
	return ($_SESSION['admin']? '<a href = "edit.php?category=' .$category. '">[' .$lang['edit']. ']</a><a href = "delete.php?category=' .$category. '">[' .$lang['delete']. ']</a>' : '').hook('manageCategory', $category);
}

function manageLink($link)
{
	global $lang;
	return ($_SESSION['admin']? '<a href = "edit.php?link=' .$link. '">[' .$lang['edit']. ']</a><a href = "delete.php?link=' .$link. '">[' .$lang['delete']. ']</a>' : '').hook('manageLink', $link);
}

?>

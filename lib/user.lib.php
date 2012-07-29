<?php

function array_change_value_case(array $input, $case = CASE_LOWER) {
    switch ($case) {
        case CASE_LOWER:
            return array_map('strtolower', $input);
            break;
        case CASE_UPPER:
            return array_map('strtoupper', $input);
            break;
        default:
            trigger_error('Case is not valid, CASE_LOWER or CASE_UPPER only', E_USER_ERROR);
            return false;
    }
}


function isAdmin()
{
        if (array_key_exists('REMOTE_USER',$_SERVER)) {
                $user = strtolower($_SERVER['REMOTE_USER']);
                $filename = '.htadmins';
		$admins = array_change_value_case(file($filename, FILE_IGNORE_NEW_LINES), CASE_LOWER);
                if (in_array($user,$admins)) {
			$_SESSION['role'] = 'admin';
                        return true;
                }
		else
		{
			return false;
		}
	return false;
        }
}

function isAuthor($entry)
{
	return isset($_SESSION[$entry]);
}

/*
function login($password)
{
	global $config;
	if(hide($password) === $config['password'])
	{
		$_SESSION['role'] = 'admin';
		return true;
	}
	return false;
}
*/

?>

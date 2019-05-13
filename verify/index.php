<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/header.php');
    $verid = $_GET['user'];
    $cn = $_GET['cn'];
    if(DB::Query('SELECT confirmed FROM email WHERE user_id = :user_id', array(':user_id' => $verid))['0']['confirmed'] === '1')
    {
        include('verified.php');
    }
    else
    {
        if($cn == DB::Query('SELECT confirmed FROM email WHERE user_id = :user_id', array(':user_id' => $verid))['0']['confirmed'])
        {
            DB::Query('UPDATE email SET confirmed = 1 WHERE user_id = :user_id', array(':user_id' => $verid));
            include('succeeded.php');
        }
        else
        {
            include('failed.php');
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>InventShare - Verify Your E-Mail</title>
    </head>
</html>
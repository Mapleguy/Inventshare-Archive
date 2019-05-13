<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/header.php');
    $ech;
    $user_id = $_GET['user'];
    $tmp = $_GET['tmp'];
    if(DB::Query('SELECT temp FROM passwords WHERE user_id = :user_id', array(':user_id' => $user_id))['0']['temp'] === $tmp)
    {
        require_once($_SERVER['DOCUMENT_ROOT'].'/recover/password/reset.php');
    }
    else
    {
        require_once($_SERVER['DOCUMENT_ROOT'].'/recover/password/fail.php');
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Reset Your Password on InventShare</title>
        <link rel="stylesheet" href="https://inventshare.co/css/act/recover.css">
    </head>
    <body>
        
    </body>
</html>
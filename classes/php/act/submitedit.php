<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/classes/php/db.php');
    session_start();
    if(isset($_POST['dosubmit']))
    {
        DB::Query('UPDATE users SET fname = :fname WHERE user_id = :userid', array(':userid' => $_SESSION['user_id'], ':fname' => $_POST['fname']));
        DB::Query('UPDATE users SET lname = :lname WHERE user_id = :userid', array(':userid' => $_SESSION['user_id'], ':lname' => $_POST['lname']));
        DB::Query('UPDATE profiles SET summary = :summary WHERE user_id = :userid', array(':userid' => $_SESSION['user_id'], ':summary' => $_POST['summary']));
        DB::Query('UPDATE profiles SET location = :location WHERE user_id = :userid', array(':userid' => $_SESSION['user_id'], ':location' => $_POST['location']));
    }
?>
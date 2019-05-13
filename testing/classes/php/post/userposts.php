<?php
    require_once($_SERVER['DOCUMENT_ROOT'].'/testing/classes/php/db.php');
    $posts[] = DB::Query('SELECT inventionid FROM inventions WHERE inventorid = :user', array(':user' => $_POST['userid']));
    echo json_encode($posts);
?>